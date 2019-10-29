<?php
//connect to database
include("dbConn.inc");

$display_block = "<h1>My Categories</h1>
<p>Select a category to see its items.</p>";

//show categories first
$get_cats_sql = "SELECT id, cat_title, cat_desc FROM store_categories ORDER BY cat_title";
$get_cats_res = $conn -> query($get_cats_sql);
if ($get_cats_res -> num_rows < 1) {
   $display_block = "<p><em>Sorry, no categories to browse.</em></p>";
}
else {
   while ($cats = $get_cats_res -> fetch_array()) {
        $cat_id  = $cats['id'];
        $cat_title = strtoupper(stripslashes($cats['cat_title']));
        $cat_desc = stripslashes($cats['cat_desc']);

        $display_block .= "<p><strong><a href=\"".$_SERVER["PHP_SELF"]."?cat_id=".$cat_id."\">".$cat_title."</a></strong><br/>".$cat_desc."</p>";

        if (isset($_GET["cat_id"])) {
			if ($_GET["cat_id"] == $cat_id) {
			   //get items
			   $get_items_sql = "SELECT id, item_title, item_price FROM store_items WHERE cat_id = '".$cat_id."' ORDER BY item_title";
			   $get_items_res = $conn -> query($get_items_sql) or die("Couldn't connect");

			    if ($get_items_res -> num_rows < 1) {
					$display_block = "<p><em>Sorry, no items in this category.</em></p>";
			    }
				else {
					$display_block .= "<ul>";

					while ($items = $get_items_res -> fetch_array()) {
					   $item_id  = $items['id'];
					   $item_title = stripslashes($items['item_title']);
					   $item_price = $items['item_price'];

					   $display_block .= "<li><a href=\"showitem.php?item_id=".$item_id."\">".$item_title."</a></strong> (\$".$item_price.")</li>";
					}

					$display_block .= "</ul>";
				}

				//free results
				$get_items_res -> free();

			}
		}
	}
}
//free results
$get_cats_res -> free();

//close connection to MSSQL
$conn -> close();

?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<title>My Categories</title>
</head>
<body style="background-image: url('Images/backgroundimage.jpg');">

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="Index.html">Company XYZ</a>
		</div>
		<ul class="nav navbar-nav">
			<li><a href="Index.html">Index</a></li>
			<li class="active"><a href="seestore.php">See Store</a></li>
			<li><a href="showcart.php">See Cart</a></li>
			<li><a href="About_Us.html">About Us</a></li>
			<li><a href="Contact_Us.html">Contact Us</a></li>
		</ul>
	</div>
</nav>

<?php echo $display_block; ?>

</body>
</html>