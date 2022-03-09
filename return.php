<?php
session_start();
$Body = "";
$errors = 0;
$UserID = 0;
$Email_db = 0;
/*
if (isset($_GET['userID']))
	$UserID = $_GET['userID']; */
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
	if ($_SESSION['role'] != 'client'){
		++$errors;
		$Body .= "<p><strong> Request failed! </strong>You need to be a client to rent equipment</p>";
	}
}

if ($errors == 0) {
    try {
		
		#Return a product
        $conn = @mysqli_connect("localhost", "root", "", "rental");
	
		$DBName = "rental";
		$result = @mysqli_select_db($conn, $DBName);
		
        
        $TableName = "start_rent";
		$Email_db = $_SESSION['email'];
		#delete rent details from start rent table
        $sql = "DELETE FROM $TableName where rentID = '$RentID'"; 
		$qRes = @mysqli_query($conn, $sql);
		
		#insert to rent history table
		
		
		#Update rent status to available
		$sql = "UPDATE available_rental SET status = 'Available', rentUser = 'NULL' WHERE rentID = '$RentID'"; 
		$qRes = @mysqli_query($conn, $sql) ;
		$DisplayDate = date("Y-m-d");
		
		$Body .= "<p>You have successfully returned an equipment RentID: " . " $RentID  on $DisplayDate.</p>\n";
		mysqli_commit($conn);
        mysqli_close($conn);
    }
    catch (mysqli_sql_exception $e) {
		$mysqli_rollback();
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
<title>Request opportunities</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<h1>IT Rental</h1>
<h2>Rent Requested</h2>
<?php
echo $Body;
		$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
  echo "<br> <button class ='back'> <a href='$url'> < Back </a> </button>"; 
?>
</body>
</html>
