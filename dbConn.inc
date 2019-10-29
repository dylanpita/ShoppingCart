<?php

$conn = @new mysqli('localhost', 'root', '', 'shop');
if ($conn -> connect_error) {
	echo "Connection failed: $conn -> connect_error";
	exit;
}

?>