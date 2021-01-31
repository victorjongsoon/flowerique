<?php 
// Include the code that contains shopping cart's functions
include_once("cartFunctions.php");

// Check if user logged in 
if (! isset($_SESSION["ShopperID"])) {
	// redirect to login page if the session variable shopperid is not set
	header ("Location: login.php");
	exit;
}

//Setting default shipping method
if (!isset($_SESSION["ShippingCost"]))
{
	$_SESSION['ShippingCost'] = "Normal";
}

include_once("mysql_conn.php");

$MainContent = "<div id='myShopCart' style='margin:auto'>";
if (isset($_SESSION["Cart"])) {
	// Retrieve from database and display shopping cart in a table
	$qry = "SELECT ShopCartItem.*, Product.ProductImage, Product.ProductDesc, (ShopCartItem.Price*ShopCartItem.Quantity) AS Total 
			FROM ShopCartItem INNER JOIN Product ON ShopCartItem.ProductID=Product.ProductID WHERE ShopCartID=?"; 
	$stmt = $conn->prepare($qry);
	$stmt->bind_param("i", $_SESSION["Cart"]); //'i' - integer 
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	
	if ($result->num_rows > 0) {
		// the page header and header row of shopping cart page
		$MainContent .= "<p class='page-title' style='text-align:center'>Shopping Cart</p>"; 
		$MainContent .= "<div class='table-responsive' >";
		$MainContent .= "<table class='table table-hover'>"; 
		$MainContent .= "<tr>";
		$MainContent .= "<th width='50px'>Item</th>"; 
		$MainContent .= "<th width='200px'></th>"; 
		$MainContent .= "<th width='90px'>Price (S$)</th>";
		$MainContent .= "<th width ='60px'>Quantity</th>";
		$MainContent .= "<th width='150px'>Total (S$)</th>";
		$MainContent .= "<th>&nbsp;</th>";
		$MainContent .= "</tr>";
		$MainContent .= "</thead>";
		
		// Declare an array to store the shopping cart items in session variable 
		$_SESSION["Items"] = array();
		 
		// Display the shopping cart content
		$subTotal = 0; // Declare a variable to compute subtotal before tax
		$totalItems = 0; // Declare a variable to total items in cart

		$MainContent .= "<tbody>";
		while ($row = $result->fetch_array()) {
			$MainContent .= "<tr>"; 
			$MainContent .= "<td><img class='img-fluid' src='./Images/Products/$row[ProductImage]' />";
			//$MainContent .= "<td><img class='img-fluid' src=$img />";
			$MainContent .= "<td style='width:50%'><span class='sc-product-title'><a href='productDetails.php?pid=$row[ProductID]'>$row[Name]</a></span><br />";
			$MainContent .= "<span class='sc-product-information'>Product ID: $row[ProductID]</span></td>"; 
			$formattedPrice = number_format($row["Price"], 2);
			$MainContent .= "<td>$formattedPrice</td>";
			$MainContent .= "<td>"; 
			// Update quantity of purchase -
			$MainContent .= "<form action='cartFunctions.php' method='post'>";
			$MainContent.= "<select name='quantity' onChange='this.form.submit()'>";
			for ($i =1; $i <= 10; $i++) {// To populate drop-down list from 1 to 10
				if($i ==$row["Quantity"])
					//Select the drop-down list item with value same as the quantity of purchase 
					$selected = "selected";
				else 
					$selected = ""; // No specific item is selected 
				$MainContent .= "<option value='$i' $selected>$i</option>";
			}
			$MainContent .= "</select>";
			$MainContent .= "<input type='hidden' name='action' value='update' />";
			$MainContent .= "<input type='hidden' name='product_id' value='$row[ProductID]'/>";
			$MainContent .= "</form>"; 
			$MainContent .= "</td>"; 
			$formattedTotal = number_format($row["Total"],2);
			$MainContent .= "<td>$formattedTotal</td>"; 

			//Remove Item
			$MainContent .= "<td>"; 
			$MainContent .= "<form action='cartFunctions.php' method='post'>";
			$MainContent .= "<input type='hidden' name='action' value='remove' />";
			$MainContent .= "<input type='hidden' name='product_id' value='$row[ProductID]' />";
			$MainContent .= "<input type='image' class='sc-icon' src='images/trash-can.png' title='Remove Item'/>"; 
			$MainContent .= "</form>"; 
			$MainContent .= "</td>"; 
			$MainContent .= "</tr>";

		    // Store the shopping cart items in session variable as an associate array
			$_SESSION["Items"] = array("productId"=>$row["ProductID"],
									   "name"=>$row["Name"],
									   "price"=>$row["Price"],
									   "quantity"=>$row["Quantity"]);
									   $totalItems += $row["Quantity"];
			
			// Accumulate the running sub-total
			$subTotal += $row["Total"];

			//Codes to input to get and show Shipping fee/Delivery Chargers 
			if ($subTotal < 200){
				if ($_SESSION['ShippingCost'] == "Normal"){
					$deliveryChargers =  5;
				}else{
					$deliveryChargers =  10;
				}
			}else{
				$deliveryChargers = 0;
			}

			//Codes to input to get current tax percentage from table, "gst"
			$qry = "SELECT TaxRate FROM gst WHERE EffectiveDate IN (SELECT max(EffectiveDate) FROM gst);"; 
			$result2 = $conn->query($qry);
			while ($row2 = $result2->fetch_array()){
				$taxCal = $row2["TaxRate"];
			}
			
			//Codes to calculate total tax payable and grandtotal of the shopper purchase
			$totalTaxes = ($subTotal/100) * $taxCal;
			$grandTotal = $subTotal + $deliveryChargers + $totalTaxes; 
		}
		$MainContent .= "</tbody>";
		$MainContent .= "</table>";
		$MainContent .= "</div>";
		
		/*
		// Add PayPal Checkout button on the shopping cart page    // THIS PART NEED TO CHECK 
		$MainContent .= "<form method='post' action='checkoutProcess.php'>";
		//Adding radio buttons for selecting shipping methods
		$MainContent .= "<br />";
		$MainContent .= "<br />";
		$MainContent .= "<input type='radio' id='Normal' value='Normal' name='shippingmethod'  checked='checked' /> ($5) Normal Shipping - Delivered within 2 working days";  //onclick='changeShippingMethod()'
		$MainContent .= "<br/> ";
		$MainContent .= "<input type='radio' id='Express' value='Express' name='shippingmethod' />  ($10) Express Shipping - Delivered within 24 hours"; //onclick='changeShippingMethod()'
		$MainContent .= "<input type='hidden' name='subTotal' value='$subTotal'>";
		$MainContent .= "<input type='hidden' name='totalTaxes' value='$totalTaxes'>";
		$MainContent .= "<input type='hidden' name='shippingmethod' value='$deliveryChargers'>"; // Add on  
		$MainContent .= "<input type='hidden' name='grandTotal' value='$grandTotal'>";
		$MainContent .= "</form>";
		*/

		//Drop down list 
		$MainContent .= "<b>Delivery option: </b>";
		$MainContent .= "<form action='cartFunctions.php' method='post'>";
		$MainContent.= "<select name='shippingSelection' onChange='this.form.submit()'>";
		$products = array("Normal" => "($5) Normal Shipping - Delivered within 2 working days", "Express" => "($10) Express Shipping - Delivered within 24 hours"); 
		foreach($products as $key => $value){ 
			if($key == $_SESSION['ShippingCost']){
				//$selected = "selected";
				$MainContent .=  "<option value=$key selected>$value</option>";
			}else{
				$MainContent .=  "<option value=$key> $value</option>";
			}
		}
		$MainContent .= "</select>";
		$MainContent .= "<input type='hidden' name='action' value='shipping' />";
		$MainContent .= "</form>"; 

		// Display the summary of the user purchase at the end of the user shopping cart

		//Subtotal 
		$MainContent .= "<p style='text-align:right; font-size:15px'><b> Subtotal (" . $totalItems . " items):</b> SGD $" . number_format($subTotal,2);

		//Shipping fee 
		if($subTotal >= 200){
			$MainContent .= "<br><style='text-align:right; font-size:15px'><b>Shipping Fee: </b>Free";
		}else{
			$MainContent .= "<br><style='text-align:right; font-size:15px'><b>Shipping Fee: </b>SGD $" . number_format($deliveryChargers,2);	
		}

		//Tax/GST  
		$MainContent .= "<br><style='text-align:right; font-size:15px'><b>Tax Fee: </b>SGD $" . number_format($totalTaxes,2);

		//GrandAmount 	
		$MainContent .= "<br><style='text-align:right; font-size:15px'><b>Grand Total: </b>SGD $" . number_format($grandTotal,2);	
		
		$_SESSION["SubTotal"] = round($subTotal,2);

		//Update on $SESSION["NumCartItem"]
		//Enforce $_SESSION["NumCartItem"] to be update items to be update continuously in the nav bar 
		if($totalItems > 0){
			$_SESSION["NumCartItem"] = $totalItems;
		}else{
			unset($_SESSION["NumCartItem"]);
		}

		// Add PayPal Checkout button on the shopping cart page // New Version 
		$MainContent .= "<form method='post' action='checkoutProcess.php'>";
		$MainContent .= "<input type='image' style='float:right;'
						src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif'>";
		$MainContent .= "<input type='hidden' name='subTotal' value='$subTotal'>";
		$MainContent .= "<input type='hidden' name='totalTaxes' value='$totalTaxes'>";
		$MainContent .= "<input type='hidden' name='shippingmethod' value='$_SESSION[ShippingCost]>"; // Add on  
		$MainContent .= "<input type='hidden' name='grandTotal' value='$grandTotal'>";
		$MainContent .= "</form></p>";

		/* Orginal code for the paypal button here 
		$MainContent .= "<br/>";
		$MainContent .= "<br/>";
		$MainContent .= "<input type='image' style='float:right;'
						 src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif'>";
		$MainContent .= "</form></p>";
		*/

		/* Orignal codes from the radio button codes 
		// Add PayPal Checkout button on the shopping cart page    // THIS PART NEED TO CHECK 
		$MainContent .= "<form method='post' action='checkoutProcess.php'>";
		//Adding radio buttons for selecting shipping methods
		$MainContent .= "<br />";
		$MainContent .= "<br />";
		$MainContent .= "<input type='radio' id='Normal' value='Normal' name='shippingmethod'  checked='checked' /> ($5) Normal Shipping - Delivered within 2 working days";  //onclick='changeShippingMethod()'
		$MainContent .= "<br/> ";
		$MainContent .= "<input type='radio' id='Express' value='Express' name='shippingmethod' />  ($10) Express Shipping - Delivered within 24 hours"; //onclick='changeShippingMethod()'
		$MainContent .= "<input type='hidden' name='subTotal' value='$subTotal'>";
		$MainContent .= "<input type='hidden' name='totalTaxes' value='$totalTaxes'>";
		$MainContent .= "<input type='hidden' name='shippingmethod' value='$deliveryChargers'>"; // Add on  
		$MainContent .= "<input type='hidden' name='grandTotal' value='$grandTotal'>";
		$MainContent .= "</form>";
		*/

		/*
		$MainContent .= "<form action='cartFunctions.php' method='post'>";
		$MainContent.= "<select name='shippingSelection' onChange='this.form.submit()'>";
		$products = array("Normal" => "($5) Normal Shipping - Delivered within 2 working days", "Express" => "($10) Express Shipping - Delivered within 24 hours"); //"Peter"=>"35", "Ben"=>"37", "Joe"=>"43"
		// Iterating through the product array
		//$MainContent.= "<option value='' selected disabled hidden>Choose here</option>";
		foreach($products as $key => $value){ 
			if($key == $_SESSION['ShippingCost']){
				//$selected = "selected";
				$MainContent .=  "<option value=$key name='shippingmethod' selected>$value</option>";
			}else{
				$MainContent .=  "<option value=$key name='shippingmethod'> $value</option>";
			}
		}
		$MainContent .= "</select>";
		$MainContent .= "<input type='hidden' name='action' value='shipping' />";
		$MainContent .= "</form>"; 
		$MainContent .= "" .$_SESSION['ShippingCost'] ."<br>";
		*/
	}
	else {
		$MainContent .= "<h3 style='text-align:center; color:red;'>Empty shopping cart!</h3>";
	}
	$MainContent .= "</div>";
}else{
	$MainContent = "<h3 style='text-align:center; color:red;'>Empty shopping cart!</h3>";
}

$conn->close(); // Close database connection

include("MasterTemplate.php"); 
?>
