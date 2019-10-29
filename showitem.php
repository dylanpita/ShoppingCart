<?php
//connect to database
include("dbConn.inc");

$display_block = "<h1>My Store - Item Detail</h1>";

//validate item
$get_item_sql = "SELECT c.id as cat_id, c.cat_title, si.item_title, si.item_price, si.item_desc, si.item_image FROM store_items AS si LEFT JOIN store_categories AS c on c.id = si.cat_id WHERE si.id = '".$_GET["item_id"]."'";
$get_item_res = $conn -> query($get_item_sql) or die("Couldn't connect");

if ($get_item_res -> num_rows < 1) {
   //invalid item
   $display_block .= "<p><em>Invalid item selection.</em></p>";
}
else {
   //valid item, get info
   while ($item_info = $get_item_res -> fetch_array()) {
	   $cat_id = $item_info['cat_id'];
	   $cat_title = strtoupper(stripslashes($item_info['cat_title']));
	   $item_title = stripslashes($item_info['item_title']);
	   $item_price = $item_info['item_price'];
	   $item_desc = stripslashes($item_info['item_desc']);
	   $item_image = $item_info['item_image'];
	}

   //make breadcrumb trail
   $display_block .= "<p><strong><em>You are viewing:</em><br/>
   <a href=\"seestore.php?cat_id=".$cat_id."\">".$cat_title."</a> &gt; ".$item_title."</strong></p>
   <table cellpadding=\"3\" cellspacing=\"3\">
   <tr>
   <td valign=\"middle\" align=\"center\"><img src=\"Images/$item_image.\"/></td>
   <td style='width: 50px;'></td>
   <td valign=\"middle\"><p><strong>Description:</strong><br/>".$item_desc."</p>
   <p><strong>Price:</strong> \$".$item_price."</p>
   <form method=\"post\" action=\"addtocart.php\">";

   //free result
   $get_item_res -> free();
}
   //get colors
   $get_colors_sql = "SELECT item_color FROM store_item_color WHERE item_id = '".$_GET["item_id"]."' ORDER BY item_color";
   $get_colors_res = $conn -> query($get_colors_sql) or die("Couldn't connect");

   if ($get_colors_res -> num_rows > 0) {
        $display_block .= "<p><strong>Available Colors:</strong><br/>
        <select name=\"sel_item_color\">";

        while ($colors = $get_colors_res -> fetch_array()) {
           $item_color = $colors['item_color'];
           $display_block .= "<option value=\"".$item_color."\">".$item_color."</option>";
       }
       $display_block .= "</select>";
   }

   //free result
   $get_colors_res -> free();

   //get sizes
   $get_sizes_sql = "SELECT item_size FROM store_item_size WHERE item_id = ".$_GET["item_id"]." ORDER BY item_size";
   $get_sizes_res = $conn -> query($get_sizes_sql) or die("Couldn't connect");

   if ($get_sizes_res -> num_rows > 0) {
       $display_block .= "<p><strong>Available Sizes:</strong><br/>
       <select name=\"sel_item_size\">";

       while ($sizes = $get_sizes_res -> fetch_array()) {
          $item_size = $sizes['item_size'];
          $display_block .= "<option value=\"".$item_size."\">".$item_size."</option>";
       }
	   $display_block .= "</select>";
   }
   
   //free result
   $get_sizes_res -> free();

   $display_block .= "
   <p><strong>Select Quantity:</strong>
   <select name=\"sel_item_qty\">";

   for($i=1; $i<11; $i++) {
       $display_block .= "<option value=\"".$i."\">".$i."</option>";
   }

   $display_block .= "
   </select>
   <input type=\"hidden\" name=\"sel_item_id\" value=\"".$_GET["item_id"]."\"/>
   <p><input type=\"submit\" name=\"submit\" value=\"Add to Cart\"/></p>
   </form>
   </td>
   </tr>
   </table>";

//close connection to MSSQL
$conn -> close();

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
<p>
	<?php
		$message = "";
		if(isset($_COOKIE["message"]))  {
			$message = $_COOKIE["message"];
			echo "<div class=\"jumbotron text-center\"><h2>" .$message. "</h2></div>";
		}
		setcookie("message", "", time()-1);
	?>
</p>
<?php echo $display_block; ?>

</body>
</html>