<?php
//connect to database
include("library.php");

session_start();

$display_block = "";

$orders = array();
if (isset($_SESSION["orders"])) {
	$orders = unserialize($_SESSION["orders"]);
	
	$listOrdersID = array();
	
	$display_block .= "<h1>Your Shopping Cart</h1>";

    //get info and build cart display
    $display_block .= "
    <table width=\"100%\" style=''>
    <tr>
    <th>Title</th>
    <th>Price</th>
    <th>Sub Total</th>
	<th>Taxes</th>
	<th>Total Price</th>
    <th>Quantity</th>
    <th>Size</th>
    <th>Colour</th>
    <th>Action</th>
    </tr>";
	
	$totalTaxes = 0.0;
	$totalSubTotals = 0.0;
	$totalTotals = 0.0;
	
    foreach ($orders as $order) {
		
   	    $item_title = $order -> get_itemName();
   	    $item_price = $order -> get_itemPrice();
   	    $item_qty = $order -> get_quantityWanted();
   	    $item_color = $order -> get_itemColor();
   	    $item_size = $order -> get_itemSize();
	    $subtotal = $order -> calculateSubTotal();
		$taxes = $order -> calculateTaxTotal();
		$total = $order -> calculateTotal();

		$totalSubTotals += $subtotal;
		$totalTaxes += $taxes;
		$totalTotals += $total;
		
   	    $display_block .= "
   	    <tr>
   	    <td align=\"center\">$item_title <br></td>
		<td align=\"center\">\$ $item_price <br></td>
		<td align=\"center\">\$ $subtotal</td>
		<td align=\"center\">\$ $taxes</td>
		<td align=\"center\"><strong>$ $total</strong></td>
   	    <td align=\"center\">$item_qty <br>
   	    <td align=\"center\">$item_size <br></td>
   	    <td align=\"center\">$item_color <br></td>
   	    <td align=\"center\"><a href=\"removefromcart.php?id=".$order -> get_itemID()."&delete_all=false\">remove</a></td>
   	    </tr>";
    }

    $display_block .= "</table>";
	
	$totalTotals += 5.99;
	
	$display_block .= "<br><br><table align=\"right\">
							 <tr><th>Order Subtotal</th><td>$" . $totalSubTotals ."</td></tr>
							 <tr><th>Order Taxes</th><td>$" . $totalTaxes ."</td></tr>
							 <tr><th>Shipping</th><td>$5.99</td></tr>
							 <tr><th>Order Total</th><td>$" . $totalTotals ."</td></tr>
				      </table>";
	$display_block .=" <br><br>
						<div class=\"text-center\">
							<a href=\"removefromcart.php?delete_all=true\"><button type=\"button\" class=\"btn btn-primary\">Remove All</button></a>
							<a href=\"seestore.php\"><button type=\"button\" class=\"btn btn-primary\">Order More</button></a>
							<a href=\"checkout.php\"><button type=\"button\" class=\"btn btn-primary\">Checkout</button></a>
						</div>";
}
else {
	$display_block .= "<h1> Your cart is empty, consider adding items to it! </h1>";
	$display_block .=" <br><br>
						<div class=\"text-center\">
							<a href=\"seestore.php\"><button type=\"button\" class=\"btn btn-primary\">Order More</button></a>
						</div>";
}
?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<title>My Store</title>
<style>
	th, td {
		padding: 5px;
		text-align: center;
		border: 2px solid black;
	}
	button {
		width: 160px;
	}
	tr {
		background-color: #f2f2f2;
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

<?php echo $display_block; ?>

</body>
</html>
