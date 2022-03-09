<?php
session_start();
$Body = "";
$errors = 0;
$UserID = 0;
$Email_db = 0;
/*
if (isset($_GET['userID']))
	$UserID = $_GET['userID']; */

$conn = @mysqli_connect("localhost", "root", "", "rental");
if (isset($_SESSION['userID']))
	$UserID = $_SESSION['userID']; 
	
	#$Email_db = $_SESSION['email'];
else {
	$Body .= "<p>You have not logged in or registered. Please return to the <a href='UserLogin.php'>Registration / Log In page</a>.</p>";
	++$errors;
}
if ($errors == 0) {
	if (isset($_GET['rentID']))
		$RentID = $_GET['rentID'];
	else {
		$Body .= "<p>You have not selected an product. Please return to the <a href='item_listings.php?". SID . "'>Item listings page</a>.</p>";
		++$errors;
	}
}

if ($errors == 0) {
		

	
	//else {
	//	$Body .= "<p>You have not selected days to rent. Please return to the <a href='item_listings.php?". SID . "'>Item listings page</a>.</p>";
	//	++$errors;
	//}
}

if ($errors == 0){
	if (isset($_POST['day'])){
		$day = $_POST['day'];
		$validate = "/^[1-9]+/";
		if (!preg_match($validate, $day)){
		
			$Body .= "<p style = 'color:red'>ERROR! Please enter a numeric number 1-1000</p> ";
			++$errors;
		}
	}

	
}
	

if ($errors == 0) {
	if ($_SESSION['role'] != 'client'){
		++$errors;
		$Body .= "<p><strong> Request failed! </strong>You need to be a client to rent equipment</p>";
	}
}

if ($errors == 0 && isset($_POST['day'])) {
    try {
        $conn = @mysqli_connect("localhost", "root", "", "rental");
	
		$DBName = "rental";
		$result = @mysqli_select_db($conn, $DBName);
		
		
		$cat = $_GET['category'];
		$brand = $_GET['brand'];
		
        $DisplayDate = date("Y-m-d");
        $DatabaseDate = date("Y-m-d H:i:s");
		
		$end_date = strtotime("+". $day . " day", strtotime("$DatabaseDate"));
		$end_date =date("Y-m-d", $end_date);
		#echo date("Y-m-d", $end_date);

        $TableName = "start_rent";
		$Email_db = $_SESSION['email'];
		#Insert rent details into start rent table
        $sql_rent = "INSERT INTO $TableName (rentID, userID, email, start_date, end_date) VALUES ('$RentID', '$UserID', '$Email_db', '$DatabaseDate','$end_date')";
		$abc = @mysqli_query($conn, $sql_rent) ;
		 
		#Insert details into history 
		$sql = "INSERT INTO rent_history (rentID, rentUser, category, brand, start_date, end_date) VALUES ('$RentID', '$Email_db', '$cat', '$brand', '$DatabaseDate', '$end_date')";
		$cde = @mysqli_query($conn, $sql);
		
		#Update item table with rent duration
		$sql = "UPDATE available_rental SET start_date = '$DisplayDate', end_date = '$end_date' where rentID = '$RentID'";
		$qRes = @mysqli_query($conn, $sql) ;
		
		#Update rent status to Unavailable
		$sql_status = "UPDATE available_rental SET status = 'Unavailable', rentUser = '$Email_db' WHERE rentID = '$RentID'"; 
		$qRes = @mysqli_query($conn, $sql_status) ;
		

		$rent_per_day = $_GET['regular'];
		$rent_item = $_GET['category'];
		$rent_cost = $day * $_GET['regular'];
		$Body .= "You have entered "." $day "." days";
		$Body .= "<p>Your request for "."$rent_item "." rent ID:" . " $RentID " . " has been entered on " . " $DisplayDate it expires on $end_date. 
		Your rental cost per day is $"."$rent_per_day" . ", your total rental cost is $"."$rent_cost. </p>\n";
		mysqli_commit($conn);
        mysqli_close($conn);
    }
    catch (mysqli_sql_exception $e) {
		#$mysqli_rollback(conn);
        $Body .= "<p>Unable to execute the query.</p>\n";
        ++$errors;
    }
}

if ($UserID > 0)
	$Body .= "<p>Return to the <a href='item_listings.php?". SID . "'>Item listing</a> page.</p>\n";
else
	$Body .= "<p>Please <a href='UserLogin.php'>Register or Log In</a> to use this page.</p>\n";

#if ($errors == 0)
	#setcookie("LastRequestDate", urlencode($DisplayDate), time()+60*60*24*7); //, "/examples/internship/");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Rent request</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<h1>IT Rental</h1>
<h2>Rent Requested</h2>
<?php
if ($errors == 0){
	if (!isset($_POST['input_day'])){
		echo "Please enter days to rent: ";
		echo "<form method='post'>";
		echo "<input type = 'text' name = 'day' value=''>";
		echo "<input type='submit' value='submit' name='input_day'>";
		echo "</form>";
	}
}
	
echo $Body;
echo "<p>Return to the <a href='profilepage.php?". SID . "'> profile page.</a></p>\n";

//$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
 // echo "<br> <button class ='back'> <a href='$url'> < Back </a> </button>"; 
?>
</body>
</html>
