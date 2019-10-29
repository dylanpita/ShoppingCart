<?php
	include("library.php");
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
	}
	table, td {
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
	<h1> Enter your Shipping and Billing Information </h1>
	<br>
<form action="invoice" method="get">
	<table align="center">
	<tr>
		<td colspan="2" align="center">Full Name: <input type="text" name="name" required></td>
	</tr>
	<tr>
		<td align="right">Address: <input type="text" name="address" required></td>
		<td align="right">Postal Code: <input type="text" name="postalCode" required></td>
	</tr>
	<tr>
		<td align="right">City: <input type="text" name="city" required></td>
		<td align="right">State: <input type="text" name="state" required></td>	
	</tr>
	<tr>
	</tr>
	<tr>
		<td colspan="2">Preffered Shipping Method: <select name="shippingMethod">
													<?php
														foreach ($shipping_arr as $key => $value)
															echo "<option value=".$key.">".$key." - $" .$value."</option>";
													?>
												   </select>
		</td>
	</tr>
	<tr>
		<td colspan="2">Payment Method: &nbsp;&nbsp;Visa<input type="radio" name="paymentMethod" value="Visa" checked>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MasterCard<input type="radio" name="paymentMethod" value="MasterCard"></td>
	</tr>
	<tr>
		<td colspan="2" align="center">Card Number: <input type="text" name="cardNumber" required></td>
	</tr>
	<tr>
		<td colspan="2" align="center">Month: <input type="number" name="expMonth" min="1" max="12" required> Year: <input type="number" name="expYear" min="2019" max="9999"required> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CVC: <input type="text" name="cvc" size="3" required></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><a href="invoice.php"><input class="btn btn-primary" type="submit" value="Complete Order"></a></td>
	</tr>
	</table>
</form>
<div class="text-center">
	<a href="showcart.php"><button type="button" class="btn btn-primary">Return to Cart</button></a>
	<a href="seestore.php"><button type="button" class="btn btn-primary">Order More</button></a>
</div>
</div>
</body>
</html>