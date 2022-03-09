<?php
session_start();
$error = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
{box-sizing: border-box;}

/* Button used to open the contact form - fixed at the bottom of the page */
.open-button {
  background-color: green;
  color: white;

  border: none;
  cursor: pointer;
  opacity: 0.8;

}

/* The popup form - hidden by default */
.form-popup {
  display: none;
position: fixed;
  right: 15px;
  bottom: 10;
  
  border: 3px solid #f1f1f1;
  z-index: 9;
}

/* Add styles to the form container */
.form-container {
  max-width: 200px;
  padding: 10px;
  background-color: white;
}

/* Full-width input fields */
.form-container input[type=text], .form-container input[type=password] {
  width: 70%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

/* When the inputs get focus, do something */
.form-container input[type=text]:focus, .form-container input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/login button */
.form-container .btn {
  background-color: #04AA6D;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
</style>


<title>Search items</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>

<h1>IT rental Portal</h1>
<h2>Search items listed for rent </h2>

<?php


	#Search function
	echo " Search item";
	
	echo "<form method='get' " . " action='search.php?" . SID . "'>\n";
	echo "<input type = 'text' name = 'search' value = '' placeholder='Enter a category'>";
	echo "<input type='submit' name='submit' " . " value='Search'>\n";
	echo "</form>\n"; 
	echo "</p>";
	echo "<br>";
/*
if (isset($_SESSION['userID']))
	$InternID = $_SESSION['userID'] ;
else	
	$InternID = −1;
*/
/*
if (isset($_GET['userID']))
	$InternID = $_GET['userID'];
else
		$InternID = −1;
*/
/*
if (isset($_REQUEST['userID']))
	$InternID = $_REQUEST['userID'];
else
		$InternID = −1;
	
*/

#Last request
/*
if (isset($_COOKIE['LastRequestDate']))
	$LastRequestDate = $_COOKIE['LastRequestDate'];
else
	$LastRequestDate = "";
*/
try {
    $conn = @mysqli_connect("localhost", "root", "");
	$DBName = "rental";
	@mysqli_select_db($conn, $DBName);
    
    $TableName = "users";
    $sql = "SELECT * FROM $TableName WHERE userID='" . $_SESSION['userID'] . "'";
    $qRes = @mysqli_query($conn, $sql);
    if (mysqli_num_rows($qRes) == 0) {
        die ("<p>Invalid User ID!</p>");
    }
    $Row = mysqli_fetch_assoc($qRes);
    $UserName = $Row['first'] . " " . $Row['last'];
    
	#rented products?? 
    $TableName = "start_rent";
    $total_rent = 0;
    $sql = "SELECT COUNT(rentID) FROM $TableName WHERE userID='" . $_SESSION['userID'] . "' AND start_date IS NOT NULL";
    $qRes = @mysqli_query($conn, $sql);
    if (mysqli_num_rows($qRes) > 0) {
        $Row = mysqli_fetch_row($qRes);
        $total_rent = $Row[0];
        mysqli_free_result($qRes);
    }
        
    $selected_rent = array();
    $sql = "SELECT rentID FROM $TableName WHERE userID='" . $_SESSION['userID'] . "'";
    $qRes = @mysqli_query($conn, $sql);
    if (mysqli_num_rows($qRes) > 0) {
        while (($Row = mysqli_fetch_row($qRes))!= FALSE)
            $selected_rent[] = $Row[0];
        mysqli_free_result($qRes);
    }

    $current_rent = array();
    $sql = "SELECT rentID FROM $TableName WHERE start_date IS NOT NULL";
    $qRes = @mysqli_query($conn, $sql);
    if (mysqli_num_rows($qRes) > 0) {
        while (($Row = mysqli_fetch_row($qRes))!= FALSE)
            $current_rent[] = $Row[0];
        mysqli_free_result($qRes);
    }

    $TableName = "available_rental";
    $items = array();
    $sql = "SELECT rentID, category, brand, description, regular_cost, extend_cost, status FROM $TableName";
    $qRes = @mysqli_query($conn, $sql);
    if (mysqli_num_rows($qRes) > 0) {
        while (($Row = mysqli_fetch_assoc($qRes))!= FALSE)
            $items[] = $Row;
        mysqli_free_result($qRes);
    }
    mysqli_close($conn);

}
catch (mysqli_sql_exception $e){
    die ("<p>Error in connection with the database server or database </p>\n");
}

if (isset($_GET['search'])){
	$search = $_GET['search'];
}else{
	$error++;
	echo "Please enter a key";
}

#display Table 
echo "<table border='1' width='100%'>\n";
echo "<tr>\n";
echo " <th style='background-color:lightgrey'>Category</th>\n";
echo " <th style='background-color:lightgrey'>Brand</th>\n";
echo " <th style='background-color:lightgrey'>Description</th>\n";
echo " <th style='background-color:lightgrey'>Regular cost</th>\n";
echo " <th style='background-color:lightgrey'>Extend cost</th>\n";
echo " <th style='background-color:lightgrey'>Status</th>\n";
echo "</tr>\n";

if ($error == 0){
	echo "<p> <strong> You have searched for category:  ". $search ."</p>";
foreach ($items as $item) {
	if (str_contains(strtolower($item['category']), strtolower($search))){
		echo "<tr>\n";
		echo " <td>" . htmlentities($item['category']) . "</td>\n";
		echo " <td>" . htmlentities($item['brand']) . "</td>\n";
		echo " <td>" . htmlentities($item['description']) . "</td>\n";
		
		echo " <td>" . htmlentities($item['regular_cost']) . "</td>\n";
		echo " <td>" . htmlentities($item['extend_cost']) . "</td>\n";
		echo " <td>" . htmlentities($item['status']);
		
		#echo "rent ID: " . $item['rentID'];
			
		#echo "<button class='open-button' onclick='openForm()'>Rent</button>\n";
		if ($item['status'] == "Available")
		{
		?>
		<form action="request_rent.php?" method="get">
		<input type='hidden' value = '<?php echo $item['rentID']; ?>' name = 'rentID'>
		<input type='hidden' value = '<?php echo $item['category']; ?>' name = 'category'>
		<input type='hidden' value = '<?php echo $item['brand']; ?>' name = 'brand'>
		<input type='hidden' value = '<?php echo $item['regular_cost']; ?>' name = 'regular'> 
		<input type='hidden' value = '<?php echo $item['extend_cost'];?>' name = 'extend'> 
		
		<input type ="submit" value = "Rent" class='open-button'> </td>
		
		</form>
		   
		<?php
		}
	}
  }
}
echo "</table>\n";


	#Redirect to profile page
	echo "<br>";
	echo "<form method='post' " . " action='profilepage.php?" . SID . "'>\n";
	//echo "<input type='hidden' name='userID' " . " value='$UserID'>\n";
	echo "<input type='submit' name='submit' " . " value='Profile page'>\n";
	echo "</form>\n"; 
	
	

	
?>
<form method ='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
<?php 
echo "<hr>";

echo "<p> <input type = 'submit' value = 'LogOut' name = 'logout'> </input></p>\n";

echo "</form>";



?>




<?php 

if (isset($_POST['logout'])){
	
// Initialize the session
session_start();
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: UserLogin.php");
}
?>


</body>
</html>
