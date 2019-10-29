<?php
//connect to databas
include("library.php");

session_start();

$orders = array();

if (isset($_SESSION["orders"]) && $_GET["delete_all"] == "false") {
	$orders = unserialize($_SESSION["orders"]);
	
	foreach ($orders as $key => $order) {
		if ($_GET["id"] == $order -> get_itemID()) {
			unset($orders[$key]); 
		}
	}

	$_SESSION["orders"] = serialize($orders);

	header("Location: showcart.php");
	exit();
}
else if (isset($_SESSION["orders"]) && $_GET["delete_all"] == "true") {
	
	session_destroy();

	header("Location: showcart.php");
	exit();
}
else {
	header("Location: seestore.php");
	exit();
}
?>