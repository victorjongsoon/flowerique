<?php
session_start();
include_once("mypaypal.php");
include_once("mysql_conn.php");
$MainContent = "";

if($_POST) //Post Data received from Shopping cart page.
{
	// To Do 6 (DIY): Check to ensure each product item saved in the associative
	//                array is not out of stock


	//Update Shipping Cost of ShopCart
	$shippingMethod = $_POST["shippingmethod"];
	if($_POST['subTotal'] > 200)
	{
		$shippingMethod = "Express";
		//$discount = 10;
		$shippingCost = 0;
		$_SESSION["ShipCharge"] = 0;
	}
	else
	{
		if($shippingMethod == "Normal")
		{
			$shippingCost = 5;
			$discount = 0;
			$_SESSION["ShipCharge"] = 5;
		}
		elseif($shippingMethod == "Express")
		{
			$shippingCost = 10;
			$discount = 0;
			$_SESSION["ShipCharge"] = 10;
		}
	}
	

	
	$emergencyExit = false;
	$qry = "SELECT * FROM ShopCartItem WHERE ShopCartID=?";
		$stmt = $conn->prepare($qry);
		$stmt->bind_param('i', $_SESSION["Cart"]);
		$stmt->execute();
		$cartResult = $stmt->get_result();
		if($cartResult->num_rows > 0)
		{
			foreach($cartResult as $row)
			{
				$qry = "SELECT * FROM product WHERE ProductID=?";
				$stmt = $conn->prepare($qry);
				$stmt->bind_param('i', $row["ProductID"]);
				$stmt->execute();
				$CurrentItem = $stmt->get_result();
				$CurrentItem = $CurrentItem->fetch_array();
				
				if($CurrentItem["Quantity"] < $row["Quantity"])
				{
					$emergencyExit = true;
					break;
				}
			}
		}

		
		$conn->close();
		$stmt->close();
		if($emergencyExit == true)
		{
			$MainContent.="Product $CurrentItem[ProductID] : $CurrentItem[ProductTitle] is out of stock<br />";
			$MainContent.="Please return to shopping cart to amend your purchase. <br />";
			include("MasterTemplate.php");
			exit;
		}
		
	
	// End of To Do 6
	
	$paypal_data = '';
	// Get all items from the shopping cart, concatenate to the variable $paypal_data
	// $_SESSION['Items'] is an associative array
	foreach($_SESSION['Items'] as $key=>$item) {
		$paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='.urlencode($item["quantity"]);
	  	$paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode($item["price"]);
	  	$paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='.urlencode($item["name"]);
		$paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.urlencode($item["productId"]);
	}
	
	// To Do 1A: Receive Taxes Amount from ShoppingCart.php
	$_SESSION["Tax"] = $_POST["totalTaxes"];
	

	
		
	
	//Data to be sent to PayPal
	$padata = '&CURRENCYCODE='.urlencode($PayPalCurrencyCode).
			  '&PAYMENTACTION=Sale'.
			  '&ALLOWNOTE=1'.
			  '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
			  '&PAYMENTREQUEST_0_AMT='.urlencode($_SESSION["SubTotal"] +
				                                 $_SESSION["Tax"] + 
												 $_SESSION["ShipCharge"]).
			  '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($_SESSION["SubTotal"]). 
			  '&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($_SESSION["ShipCharge"]). 
			  '&PAYMENTREQUEST_0_TAXAMT='.urlencode($_SESSION["Tax"]). 	
			  '&BRANDNAME='.urlencode("Flowerique").
			  $paypal_data.				
			  '&RETURNURL='.urlencode($PayPalReturnURL ).
			  '&CANCELURL='.urlencode($PayPalCancelURL);	
		
	//We need to execute the "SetExpressCheckOut" method to obtain paypal token
	$httpParsedResponseAr = PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, 
	                                   $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
		
	//Respond according to message we receive from Paypal
	if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || 
	   "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {					
		if($PayPalMode=='sandbox')
			$paypalmode = '.sandbox';
		else
			$paypalmode = '';
				
		//Redirect user to PayPal store with Token received.
		$paypalurl ='https://www'.$paypalmode. 
		            '.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.
					$httpParsedResponseAr["TOKEN"].'';
		header('Location: '.$paypalurl);
	}
	else {
		//Show error message
		$MainContent .= "<div style='color:red'><b>SetExpressCheckOut failed : </b>".
		                urldecode($httpParsedResponseAr["L_LONGMESSAGE0"])."</div>";
		$MainContent .= "<pre>";
		$MainContent .= print_r($httpParsedResponseAr);
		$MainContent .= "</pre>";
	}
}

//Paypal redirects back to this page using ReturnURL, We should receive TOKEN and Payer ID
if(isset($_GET["token"]) && isset($_GET["PayerID"])) 
{	
	//we will be using these two variables to execute the "DoExpressCheckoutPayment"
	//Note: we haven't received any payment yet.
	$token = $_GET["token"];
	$playerid = $_GET["PayerID"];
	$paypal_data = '';
	
	// Get all items from the shopping cart, concatenate to the variable $paypal_data
	// $_SESSION['Items'] is an associative array
	foreach($_SESSION['Items'] as $key=>$item) 
	{
		$paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='.urlencode($item["quantity"]);
	  	$paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode($item["price"]);
	  	$paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='.urlencode($item["name"]);
		$paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.urlencode($item["productId"]);
	}
	
	//Data to be sent to PayPal
	$padata = '&TOKEN='.urlencode($token).
			  '&PAYERID='.urlencode($playerid).
			  '&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
			  $paypal_data.	
			  '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($_SESSION["SubTotal"]).
              '&PAYMENTREQUEST_0_TAXAMT='.urlencode($_SESSION["Tax"]).
              '&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($_SESSION["ShipCharge"]).
			  '&PAYMENTREQUEST_0_AMT='.urlencode($_SESSION["SubTotal"] + 
			                                     $_SESSION["Tax"] + 
								                 $_SESSION["ShipCharge"]).
			  '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode);
	
	//We need to execute the "DoExpressCheckoutPayment" at this point 
	//to receive payment from user.
	$httpParsedResponseAr = PPHttpPost('DoExpressCheckoutPayment', $padata, 
	                                   $PayPalApiUsername, $PayPalApiPassword, 
									   $PayPalApiSignature, $PayPalMode);
	
	//Check if everything went ok..
	if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || 
	   "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
	{
		// To Do 5 (DIY): Update stock inventory in product table 
		//                after successful checkout
		
		$qry = "SELECT * FROM ShopCartItem WHERE ShopCartID=?";
		$stmt = $conn->prepare($qry);
		$stmt->bind_param('i', $_SESSION["Cart"]);
		$stmt->execute();
		$cartResult = $stmt->get_result();
		if($cartResult->num_rows > 0)
		{
			foreach($cartResult as $row)
			{
				$qry = "SELECT * FROM product WHERE ProductID=?";
				$stmt = $conn->prepare($qry);
				$stmt->bind_param('i', $row["ProductID"]);
				$stmt->execute();
				$CurrentItem = $stmt->get_result();
				$CurrentItem = $CurrentItem->fetch_array();
				$quantityOfCurrentItem = $CurrentItem["Quantity"];
				$newQuantity = $quantityOfCurrentItem - ($row["Quantity"]);
				

				$qry = "UPDATE product SET Quantity=? WHERE ProductID=?";
				$stmt = $conn->prepare($qry);
				$stmt->bind_param("ii", $newQuantity, $row["ProductID"]);
				$stmt->execute();
			}
		}


		#$conn->close();
		#$stmt->close();
		
		// End of To Do 5
	
		// To Do 2: Update shopcart table, close the shopping cart (OrderPlaced=1)
		$total=$_SESSION["SubTotal"] +$_SESSION["Tax"]+$_SESSION["ShipCharge"];
		$qry="UPDATE shopcart SET OrderPlaced=1,Quantity=?,SubTotal=?,ShipCharge=?,Tax=?,Total=? WHERE ShopCartID=?";
		$stmt= $conn->prepare($qry);
		$stmt->bind_param("iddddi",$_SESSION["NumCartItem"],$_SESSION["SubTotal"],$_SESSION["ShipCharge"],$_SESSION["Tax"],$total,$_SESSION["Cart"]);
		$stmt->execute();
		$stmt->close(); 
		
		// End of To Do 2
		
		//We need to execute the "GetTransactionDetails" API Call at this point 
		//to get customer details
		$transactionID = urlencode(
		                 $httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]);
		$nvpStr = "&TRANSACTIONID=".$transactionID;
		$httpParsedResponseAr = PPHttpPost('GetTransactionDetails', $nvpStr, 
		                                   $PayPalApiUsername, $PayPalApiPassword, 
										   $PayPalApiSignature, $PayPalMode);

		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || 
		   "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
		   {
			//gennerate order entry and feed back orderID information
			//You may have more information for the generated order entry 
			//if you set those information in the PayPal test accounts.
			
			$ShipName = addslashes(urldecode($httpParsedResponseAr["SHIPTONAME"]));
			
			$ShipAddress = urldecode($httpParsedResponseAr["SHIPTOSTREET"]);
			if (isset($httpParsedResponseAr["SHIPTOSTREET2"]))
				$ShipAddress .= ' '.urldecode($httpParsedResponseAr["SHIPTOSTREET2"]);
			if (isset($httpParsedResponseAr["SHIPTOCITY"]))
			    $ShipAddress .= ' '.urldecode($httpParsedResponseAr["SHIPTOCITY"]);
			if (isset($httpParsedResponseAr["SHIPTOSTATE"]))
			    $ShipAddress .= ' '.urldecode($httpParsedResponseAr["SHIPTOSTATE"]);
			$ShipAddress .= ' '.urldecode($httpParsedResponseAr["SHIPTOCOUNTRYNAME"]). 
			                ' '.urldecode($httpParsedResponseAr["SHIPTOZIP"]);
				
			$ShipCountry = urldecode(
			               $httpParsedResponseAr["SHIPTOCOUNTRYNAME"]);
			
			$ShipEmail = urldecode($httpParsedResponseAr["EMAIL"]);			
			

			$deliveryDate = new DateTime();
			if($_SESSION["ShipCharge"] == 0)
			{
				date_add($deliveryDate, date_interval_create_from_date_string("1 days"));
				$deliveryDateString = $deliveryDate->format('Y-m-d');
				$shippingMethod = "Express";
			}
			elseif($_SESSION["ShipCharge"] == 5)
			{
				date_add($deliveryDate, date_interval_create_from_date_string("2 days"));
				$deliveryDateString = $deliveryDate->format('Y-m-d');
				$shippingMethod = "Normal";
			}
			elseif($_SESSION["ShipCharge"] == 10)
			{
				date_add($deliveryDate, date_interval_create_from_date_string("1 days"));
				$deliveryDateString = $deliveryDate->format('Y-m-d');
				$shippingMethod = "Express";
			}

			//Retrieve the user's phone number and enter it into orderdata
			
			$qry = "SELECT * FROM shopper WHERE ShopperID=?";
			$stmt=$conn->prepare($qry);
			$stmt->bind_param('i',$_SESSION["ShopperID"]);
			$stmt->execute();
			$result = $stmt->get_result();
			//$stmt->close();
			$row = $result->fetch_array();
			$phoneNumber = $row["Phone"];

			// To Do 3: Insert an Order record with shipping information
			//          Get the Order ID and save it in session variable.
			$qry="INSERT INTO orderdata(ShipName,ShipAddress,ShipCountry,ShipPhone,ShipEmail,ShopCartID,DeliveryDate,DeliveryMode) VALUES(?,?,?,?,?,?,?,?)";

			$stmt=$conn->prepare($qry);
			$stmt->bind_param("sssssiss",$ShipName,$ShipAddress,$ShipCountry,$phoneNumber,$ShipEmail,$_SESSION["Cart"],$deliveryDateString,$shippingMethod);
			$stmt->execute();
			$stmt->close();
			$qry="SELECT LAST_INSERT_ID() AS OrderID";
			$result=$conn->query($qry);
			$row=$result->fetch_array();
			$_SESSION["OrderID"]=$row["OrderID"];
			
			

			
				
			$conn->close();
				  
			// To Do 4A: Reset the "Number of Items in Cart" session variable to zero.
			//$_SESSION["NumCartItem"]=0; //<-- GuoJun : Make changes to here only so that the number of item won't show on the nav once the payment is cleared.
			unset($_SESSION["NumCartItem"]);

	  		
			// To Do 4B: Clear the session variable that contains Shopping Cart ID.
			unset($_SESSION["Cart"]);
			
			// To Do 4C: Redirect shopper to the order confirmed page.
			header("Location: orderConfirmed.php");
			exit;
		} 
		else 
		{
		    $MainContent .= "<div style='color:red'><b>GetTransactionDetails failed:</b>".
			                urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
			$MainContent .= "<pre>";
			$MainContent .= print_r($httpParsedResponseAr);
			$MainContent .= "</pre>";
			
			$conn->close();
		}
	}
	else {
		$MainContent .= "<div style='color:red'><b>DoExpressCheckoutPayment failed : </b>".
		                urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
		$MainContent .= "<pre>";
		$MainContent .= print_r($httpParsedResponseAr);
		$MainContent .= "</pre>";
	}
}

include("MasterTemplate.php"); 
?>