<?php
//connect to database
include("dbConn.inc");
include("library.php");

session_start();

if (isset($_POST["sel_item_id"])) {
   //validate item and get title and price
    $get_iteminfo_sql = "SELECT item_title, item_price FROM store_items WHERE id =".$_POST["sel_item_id"];
    $get_iteminfo_res = $conn -> query($get_iteminfo_sql) or die("Couldn't connect");
	
	$itemColor = "";
	!empty($_POST["sel_item_color"]) ? $itemColor = $_POST["sel_item_color"] : $itemColor = "N/A";
	$itemSize = "";
	!empty($_POST["sel_item_size"]) ? $itemSize = $_POST["sel_item_size"] : $itemSize = "N/A";
	
	$get_itemqty_sql = "SELECT item_qty FROM store_item_qty WHERE item_id = " .$_POST["sel_item_id"].
												            " AND item_color = \"" .$itemColor. "\"
 												              AND item_size = \"".$itemSize. "\"";
												  
	$get_itemqty_res = $conn -> query($get_itemqty_sql) or die ("Couldn't connect");
	if ($get_itemqty_res -> num_rows == 1) {
		$item_qty = "";
		while ($qty_info = $get_itemqty_res -> fetch_array()) {
   	    	$item_qty = $qty_info['item_qty'];
		}
		if ($item_qty < $_POST["sel_item_qty"] && $item_qty != 0) {
			setcookie("message", "Item quanity in stock lower than desired amount.", time()+60);
			header("Location: showitem.php?item_id=".$_POST["sel_item_id"]."");
			exit();
		}
		else if ($item_qty == 0) {
			setcookie("message", "Item out of Stock.", time()+60);
			header("Location: showitem.php?item_id=".$_POST["sel_item_id"]."");
			exit();
		}
		
		
	}

    if ($get_iteminfo_res -> num_rows < 1) {
		//free results
		$get_iteminfo_res -> free();

		//close connection to MSSQL
		$conn -> close();
		
   	    header("Location: seestore.php");
   	    exit();
    } 
	else {
		$item_name = "";
   	    $item_price = "";
   	    while ($item_info = $get_iteminfo_res -> fetch_array()) {
   	    	$item_name = stripslashes($item_info['item_title']);
			$item_price =  stripslashes($item_info['item_price']);
		}
		
		$orders = array();
		
		$item_qty = "";
		$get_itemqty_res = $conn -> query($get_itemqty_sql) or die ("Couldn't connect");
		while ($qty_info = $get_itemqty_res -> fetch_array()) {
   	    	$item_qty = $qty_info['item_qty'];
		}
		if (isset($_SESSION["orders"])) {
			$orders = unserialize($_SESSION["orders"]);
			$found = false;
			foreach ($orders as $order) {
				if ($order -> get_itemID() == $_POST["sel_item_id"]) {
					$newQTY = $order -> get_quantityWanted() + $_POST["sel_item_qty"];
					if ($newQTY <= $item_qty) {
						$order -> set_quantityWanted($newQTY);
						$found = true;
					}
					else {
						setcookie("message", "Item quanity in stock lower than desired amount.", time()+60);
						header("Location: showitem.php?item_id=".$_POST["sel_item_id"]."");
						exit();
					}
				}
			}
			if (!$found) {
				 $newOrder = new order($_POST["sel_item_id"], $item_name, $item_price, $_POST["sel_item_qty"], $_POST["sel_item_color"], $_POST["sel_item_size"]);
		
				$_SESSION["newOrder"] = $newOrder;
			
				$orders[] = $newOrder;
		
			}
		}
		else {
			 $newOrder = new order($_POST["sel_item_id"], $item_name, $item_price, $_POST["sel_item_qty"], $_POST["sel_item_color"], $_POST["sel_item_size"]);
		
				$_SESSION["newOrder"] = $newOrder;
			
				$orders[] = $newOrder;
		}
		
		$_SESSION["orders"] = serialize($orders);
		
		//free results
		$get_iteminfo_res -> free();
		$get_itemqty_res -> free();

		//close connection to MSSQL
		$conn -> close();
		
   	    //redirect to showcart page
		header("Location: showcart.php");
		exit();
    }

} else {
   //send them somewhere else
   header("Location: seestore.php");
   exit();
}
?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<title>My Store</title>
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
			<li><a href="showcart.php">See Cart</a></li>
			<li><a href="About_Us.html">About Us</a></li>
			<li><a href="Contact_Us.html">Contact Us</a></li>
		</ul>
	</div>
</nav>
</body>
</html>

