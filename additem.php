<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>‘subscribers’</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<style>
.form {
	
  margin-top: 100px;
  margin-bottom: 100px;
  margin-right: 150px;
  margin-left: 600px;
  
}

.textbox
{
	position: absolute;
   
	left: 200px;
}

.selecttbox
{
	position: absolute;
   
	right: 910px;
}
	
	</style>
</head>
<body>
<h1>Insert item for rental</h1>
<?php
session_start();

$Body = "";

if (isset($_POST['Submit'])) 
{
	$FormErrorCount = 0;
	if (isset($_POST['category'])) {
		$category = stripslashes($_POST['category']);
		$category = trim($category);
		if (strlen($category) == 0) {
			echo "<p>You must include category!</p>\n";
			++$FormErrorCount;
		}
	}
	else {
		echo "<p>Form submittal error (No 'category' field)!</p>\n";
		++$FormErrorCount;
	}
	

	if (isset($_POST['brand'])) {
		$brand = stripslashes($_POST['brand']);
		$brand = trim($brand);
		if (strlen($brand) == 0) {
			echo "<p>You must include your brand!</p>\n";
			++$FormErrorCount;
		}
	}
	else {
		echo "<p>Form submittal error (No 'brand' field)!</p>\n";
		++$FormErrorCount;
	}	
	if (isset($_POST['description'])) {
		$description = stripslashes($_POST['description']);
		$description = trim($description);
		if (strlen($description) == 0) {
			echo "<p>You must include your description!</p>\n";
			++$FormErrorCount;
		}
	}
	else {
		echo "<p>Form submittal error (No 'description' field)!</p>\n";
		++$FormErrorCount;
	}
	if (isset($_POST['regular'])) {
		$regular = stripslashes($_POST['regular']);
		$regular = trim($regular);
		if (strlen($regular) == 0) {
			echo "<p>You must include your regular cost!</p>\n";
			++$FormErrorCount;
		}
	}
	else {
		echo "<p>Form submittal error (No 'regular' field)!</p>\n";
		++$FormErrorCount;
	}	
	if (isset($_POST['extend'])) {
		$extend = stripslashes($_POST['extend']);
		$extend = trim($extend);
		if (strlen($extend) == 0) {
			echo "<p>You must include your extend cost!</p>\n";
			++$FormErrorCount;
		}
	}
	else {
		echo "<p>Form submittal error (No 'extend' field)!</p>\n";
		++$FormErrorCount;
	}	
	if ($FormErrorCount ==0){
		if (isset($_POST['regular']))
		{
			$regular = $_POST['regular'];
			$validate = "/^[1-9]+/";
			if (!preg_match($validate, $regular))
			{
				$Body .= "Please enter an integer for regular cost!";
				++$FormErrorCount;
			}
		}
	}
	if ($FormErrorCount ==0){
		if (isset($_POST['extend']))
		{
			$extend = $_POST['extend'];
			$validate = "/^[1-9]+/";
			if (!preg_match($validate, $extend))
			{
				
				
				$Body .= "Please enter an integer for extend cost!";
				++$FormErrorCount;
			}
		}	
	}
	if ($FormErrorCount==0)
	{
		$ShowForm = FALSE;
		#include("inc_db_newsletter.php");
		try {
			$DBName = "rental";
			$conn = @mysqli_connect("localhost", "root", "",$DBName );
			$TableName = "available_rental";
			$SubscriberDate = date("Y-m-d");
			#Need edit
			
			$sql = "INSERT INTO $TableName " . "(rentID, category, brand, description, regular_cost, extend_cost) 
			VALUES " . "(NULL, '$category', '$brand', '$description', '$regular', '$extend')";
			
			@mysqli_query($conn, $sql);
			
			$itemID = mysqli_insert_id($conn);
            #echo htmlentities($brand); 
			echo "You have successfully listed an item for rental.<br />";
            echo "The item ID is $itemID.<br />";
            echo "Your item is listed in category: " . htmlentities($category) . ".</p>";
			
			echo "<form method='post' " . " action='item_listings.php?" . SID . "'>\n";
			
			echo "<input type='submit' name='submit' " . " value='View Listings'>\n";
			echo "</form>\n"; 
        }
        catch (mysqli_sql_exception $e) {
            echo "<p>Error " . mysqli_errno($conn). ": " . mysqli_error($conn) . "</p>";
		}
        mysqli_close($conn);
	}
	else
		$ShowForm = TRUE;
}
else {
	$ShowForm = TRUE;
	$brand = "";
	$category = "";
	$description="";
	$regular = "";
	$extend = "";
}

if ($ShowForm) {
	?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

	<p><strong>Category: </strong>
	<input type="text" name="category" class = "textbox" value="<?php echo $category; ?>" /></p>
		<p><strong>Brand: </strong>
	<input type="text" name="brand" class = "textbox"value="<?php echo $brand; ?>" /></p>
	<p><strong>Description: </strong>
	<input type="text" name="description" class = "textbox"value="<?php echo $description; ?>" /></p>

	<p><strong>Regular cost per day: </strong>
	<input type="text" name="regular" class = "textbox"value="<?php echo $regular; ?>" /></p>
		<p><strong>Extend cost per day: </strong>
	<input type="text" name="extend" class = "textbox"value="<?php echo $extend; ?>" /></p>
	<p><input type="Submit" name="Submit" value="Submit"/></p>
	</form>
	
	
	<?php
	
	echo $Body;
	#$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
  #echo "<br> <button class ='back'> <a href='$url'> < Back </a> </button>"; 
  
   echo "<br> <button class ='back'> Return to <a href='profilepage.php'> profile page </a> </button>"; 
	
}



	

?>
</body>
</html>
