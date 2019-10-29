<?php 
//connect to database
include("library.php");
include("dbConn.inc");

session_start();
?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<title>My Store</title>
<style>
	td {
		padding: 5px;
		font-weight: bold;
		width: 35px;
	}
	table {
		width: 60%;
	}
	.border-bottom {
		border-bottom: solid 1px black;
	}
	.border-left {
		border-left: solid 1px black;
	}
	.border-right {
		border-right: solid 1px black;
	}
	.border-top {
		border-top: solid 1px black;
	}
	.allBorder {
		border: 1px solid black;
	}
</style>
</head>
<body style="background-image: url('Images/backgroundimage.jpg');">

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="Index.html">Company XYZ</a>
		</div>
		<ul class="nav navbar-nav">
			<li><a href="Index.html">Index</a></li>
			<li><a href="seestore.php">See Store</a></li>
			<li class="active"><a href="showcart.php">See Cart</a></li>
			<li><a href="About_Us.html">About Us</a></li>
			<li><a href="Contact_Us.html">Contact Us</a></li>
		</ul>
	</div>
</nav>
<div class="jumbotron text-center">
<?php
	if (isset($_GET["confirm"])) {
		echo "<h1> Thanks for shopping with us!</h1><br><a href=\"seestore.php\"><button type=\"button\" class=\"btn btn-primary\">See Store</button></a>&nbsp;&nbsp;<a href=\"index.html\"><button type=\"button\" class=\"btn btn-primary\">Return to Homepage</button></a>";
		
	if (isset($_SESSION["orders"]))
		$orders = unserialize($_SESSION["orders"]);
	
	foreach($orders as $order) {
		$itemColor = "";
		!empty($order -> get_itemColor()) ? $itemColor = $order -> get_itemColor() : $itemColor = "N/A";
		$itemSize = "";
		!empty($order -> get_itemSize()) ? $itemSize = $order -> get_itemSize() : $itemSize = "N/A";
	
		$get_itemqty_sql = "SELECT item_qty FROM store_item_qty WHERE item_id = " .$order -> get_itemID().
												            " AND item_color = \"" .$itemColor. "\"
 												              AND item_size = \"".$itemSize. "\"";
												  
		$get_itemqty_res = $conn -> query($get_itemqty_sql) or die ("Couldn't connect");
		if ($get_itemqty_res -> num_rows == 1) {
			$item_qty = "";
			while ($qty_info = $get_itemqty_res -> fetch_array()) {
				$item_qty = $qty_info['item_qty'];
			}
			if ($item_qty >= $order -> get_quantityWanted()) {
				$newItemQTY = $item_qty - $order -> get_quantityWanted();
			
				$update_itemqty_sql = "UPDATE store_item_qty SET item_qty = " .$newItemQTY. " WHERE item_id = " .$order -> get_itemID().
												                       " AND item_color = \"" .$itemColor. "\"
 												                         AND item_size = \"".$itemSize. "\"";
																		 
				$conn -> query($update_itemqty_sql) or die("Couldn't Update");
			}
		}
		$get_itemqty_res -> free();
	}	
		$conn ->  close();
		session_destroy();
	}
	else {
	
?>
	<h1> Invoice </h1>
	<br>
	<table align="center">
		<tr class="border-left border-top border-right">
			<td align="left" colspan="2">Name:</td><td align="center">Address:</td><td align="right" colspan="2">Date:</td>
		</tr>
		<tr class="border-left border-right">
			<td align="left" colspan="2"><?php echo $_GET["name"] ?></td><td align="center"><?php echo $_GET["address"] ?></td><td align="right" colspan="2"><?php echo date("Y/m/d") ?></td>
		</tr>
		<tr class="border-left border-right">
			<td colspan="2"></td><td align="center"><?php echo $_GET["postalCode"] ?></td><td colspan="2"></td>
		</tr>
		<tr class="border-bottom border-left border-right">
			<td colspan="2"></td><td align="center"><?php echo $_GET["city"]. ", " .$_GET["state"] ?></td><td colspan="2"></td>
		</tr>
<?php
$orders = array();
if (isset($_SESSION["orders"])) {
	$orders = unserialize($_SESSION["orders"]);

    //get info and build cart display
    echo "
    <tr class=\"allBorder\">
    <td align=\"left\" class=\"allBorder\">Title</td>
    <td align=\"left\" class=\"allBorder\">Quanity</td>
    <td align=\"left\" class=\"allBorder\">Size</td>
	<td align=\"left\" class=\"allBorder\">Color</td>
	<td align=\"right\" class=\"allBorder\">Subtotal</td>
    </tr>";
	
	$totalTaxes = 0.0;
	$totalSubTotals = 0.0;
	$totalTotals = 0.0;
	
    foreach ($orders as $order) {
		
   	    $item_title = $order -> get_itemName();
   	    $item_qty = $order -> get_quantityWanted();
   	    $item_color = $order -> get_itemColor();
   	    $item_size = $order -> get_itemSize();
	    $subtotal = $order -> calculateSubTotal();
		$taxes = $order -> calculateTaxTotal();
		$total = $order -> calculateTotal();

		$totalSubTotals += $subtotal;
		$totalTaxes += $taxes;
		$totalTotals += $total;
		
   	    echo "
   	    <tr class=\"allBorder\">
   	    <td align=\"left\" class=\"allBorder\">".$item_title."</td>
		<td align=\"left\" class=\"allBorder\">".$item_qty."</td>
   	    <td align=\"left\" class=\"allBorder\">".$item_size."</td>
   	    <td align=\"left\" class=\"allBorder\">".$item_color."</td>
		<td align=\"right\" class=\"allBorder\">\$ ".$subtotal."</td>
   	    </tr>";
    }
	
	$shipping = 0;
	foreach ($shipping_arr as $key => $value) {
		if ($key == $_GET["shippingMethod"])
			$shipping = $value;
	}
	$totalTotals += $shipping;
	
	
	echo "<tr></tr>
	      <tr class=\"allBorder\">
			<td align=\"left\" colspan=\"2\">Order Taxes: $".$totalTaxes."</td><td align=\"center\">Shipping: $".$shipping."</td><td align=\"right\" colspan=\"2\">Order Total: $".$totalTotals."</td>
		  </tr>";
}
?>
	</table>
<br>
<div class="text-center">
	<a href="invoice.php?confirm=true.php"><button type="button" class="btn btn-primary">Confirm Invoice</button></a><br><br>
	<a href="showcart.php"><button type="button" class="btn btn-primary">Return to Cart</button></a>
	<a href="seestore.php"><button type="button" class="btn btn-primary">Order More</button></a>
</div>
<?php
	}
?>
</div>
</body>
</html>	