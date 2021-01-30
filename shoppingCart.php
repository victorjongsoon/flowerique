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
if (! isset($_SESSION["ShippingMethod"]))
{
	$_SESSION["ShippingMethod"] = "normaldelivery";
}

include_once("mysql_conn.php");

$MainContent = "<div id='myShopCart' style='margin:auto'>";
if (isset($_SESSION["Cart"])) {
	// To Do 1 (Practical 4): 
	// Retrieve from database and display shopping cart in a table
	$qry = "SELECT ShopCartItem.*, Product.ProductImage, Product.ProductDesc, (ShopCartItem.Price*ShopCartItem.Quantity) AS Total 
			FROM ShopCartItem INNER JOIN Product ON ShopCartItem.ProductID=Product.ProductID WHERE ShopCartID=?"; 
	$stmt = $conn->prepare($qry);
	$stmt->bind_param("i", $_SESSION["Cart"]); //'i' - integer 
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	
	if ($result->num_rows > 0) {
		// To Do 2 (Practical 4): Format and display 
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
		
		// To Do 5 (Practical 5):
		// Declare an array to store the shopping cart items in session variable 
		$_SESSION["Items"] = array();
		
		// To Do 3 (Practical 4): 
		// Display the shopping cart content
		$subTotal = 0; // Declare a variable to compute subtotal before tax
		$totalItems = 0;
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

			// To Do 6 (Practical 5):
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
				$deliveryChargers =  1;
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


			//Retrieve Current GST Pricing 
			/*
			$qry = "SELECT * FROM gst ORDER BY EffectiveDate DESC";
			$result = $conn->query($qry);
			$row = $result->fetch_array(); 
			$conn->close();
			
			while(strtotime($row["EffectiveDate"]) > date("Y-m-d"))
			{
				$row = $result->fetch_array();
			}
			$currentTaxRate = $row["TaxRate"];
			$currentTaxRateInRealPercentages = ($row["TaxRate"])/100;

			*/

			/*
			$qry = "SELECT * FROM gst ORDER BY EffectiveDate DESC";
			$result = $conn->query($qry);
			if($result->num_rows >0)
			{
				$todaysDate = new DateTime('now');
				$Date = $todaysDate->format("Y-m-d");
				$taxratenotdeterminedyet = True;
				while($taxratenotdeterminedyet == True)
				{
					$row = $result->fetch_array();
					if((strtotime($row["EffectiveDate"]) <= $Date))     //  strtotime     date("Y-m-d")   (new DateTime() > new DateTime($row["EffectiveDate"]))
					{
						$taxratenotdeterminedyet = False;
						$currentTaxRate = $row["TaxRate"];                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $currentTaxRate = 8;
					}
					
				}
				
			}
			else {
				$currentTaxRate = 8;
			}
			*/

			
			//$row = $result->fetch_array(); 
			//$conn->close();
			//$currentTaxRate = $row["TaxRate"];

			//$currentTaxRate = 8; //Temporary
			//$currentTaxRateInRealPercentages = (($currentTaxRate)/100);


			//Calculate the total tax rate
			//$totalTaxes = $subTotal*$currentTaxRateInRealPercentages;
		}
		$MainContent .= "</tbody>";
		$MainContent .= "</table>";
		$MainContent .= "</div>";
		
		// To Do 7 (Practical 5):
		// Add PayPal Checkout button on the shopping cart page
		$MainContent .= "<form method='post' action='checkoutProcess.php'>";
		//Adding radio buttons for selecting shipping methods
		$MainContent .= "<br />";
		$MainContent .= "<br />";
		$MainContent .= "<input type='radio' id='Normal' value='Normal' name='shippingmethod'  checked='checked' /> ($5) Normal Shipping - Delivered within 2 working days";  //onclick='changeShippingMethod()'
		$MainContent .= "<br/> ";
		$MainContent .= "<input type='radio' id='Express' value='Express' name='shippingmethod' />  ($10) Express Shipping - Delivered within 24 hours"; //onclick='changeShippingMethod()'
		$MainContent .= "<input type='hidden' name='subTotal' value='$subTotal'>";
		$MainContent .= "<input type='hidden' name='totalTaxes' value='$totalTaxes'>";
		$MainContent .= "<input type='hidden' name='grandTotal' value='$grandTotal'>";

		// To Do 4 (Practical 4): 
		// Display the subtotal at the end of the shopping cart
		$MainContent .= "<p style='text-align:right; font-size:15px'> Subtotal (" . $totalItems . " items): SGD $" . number_format($subTotal,2);
		if($subTotal >= 200){
			//$MainContent .= "<br><style='text-align:right; font-size:15px'> Shipping Fee: SGD $" . $deliveryChargers;	
			$MainContent .= "<br><style='text-align:right; font-size:15px'> Shipping Fee: Free";
		}

		$MainContent .= "<br><style='text-align:right; font-size:15px'>
						Tax Fee: SGD $" . number_format($totalTaxes,2);	
		if($subTotal >= 200){
			$MainContent .= "<br><style='text-align:right; font-size:15px'>Grand Total: SGD $" . number_format($grandTotal,2);	
		}else{
			$MainContent .= "<br><style='text-align:right; font-size:15px'>Grand Total: SGD $" . number_format($grandTotal,2);	
			$MainContent .= "<br><style='text-align:right; font-size:8px'>Grand Total excludes delivery fees";	
		}

						/*
		$MainContent .= "<br><style='text-align:right; font-size:15px'>
						CurrentTaxRate: " . number_format($currentTaxRate,2);	
		$MainContent .= "<br><style='text-align:right; font-size:15px'>
						CurrentTaxRateInRealPercentages: " . number_format($currentTaxRateInRealPercentages,2);	
		$MainContent .= "<br><style='text-align:right; font-size:15px'>
						rowtaxrate: " . number_format($row["TaxRate"],2);	
		$MainContent .= "<br><style='text-align:right; font-size:15px'>
						effectivedate: " . $row["EffectiveDate"];	
						*/
		
		$_SESSION["SubTotal"] = round($subTotal,2);

		//Update on $SESSION["NumCartItem"]
		//Enforce $_SESSION["NumCartItem"] to be update items to be update continuously in the nav bar 
		if($totalItems > 0){
			$_SESSION["NumCartItem"] = $totalItems;
		}else{
			unset($_SESSION["NumCartItem"]);
		}
		$MainContent .= "<br/>";
		$MainContent .= "<br/>";
		$MainContent .= "<input type='image' style='float:right;'
						 src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif'>";
		$MainContent .= "</form></p>";
		
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
