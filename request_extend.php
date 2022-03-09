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
		$Body .= "<p>You have not selected an item. Please return to the <a href='profilepage.php?". SID . "'>Item listings page</a>.</p>";
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
		
		
		
		
        $DisplayDate = date("Y-m-d");
        $DatabaseDate = $_GET['end_date'];
		
		$end_date = strtotime("+". $day . " day", strtotime("$DatabaseDate"));
		
		$new_end_date = date("Y-m-d", $end_date);
		#echo date("Y-m-d", $end_date);

        
		$Email_db = $_SESSION['email'];
		#Update rent date from the start rent table
        	$sql = "UPDATE available_rental SET end_date = '$new_end_date' where rentID = '$RentID'";
		$qRes = @mysqli_query($conn, $sql) ;
		

		#Update rent history table
        	$sql = "UPDATE rent_history SET end_date = '$new_end_date' where rentID = '$RentID'";
	    	$qRes = @mysqli_query($conn, $sql) ;
		
		$extend_cost_per_day = $_GET['extend'];
		$extend_cost = $extend_cost_per_day * $day;
		$Body .= "You have entered "." $day "." days";
		$Body .= "<p>You request extend for rent ID:" . " $RentID " . " to be extended for "." $day"." days, the new deadline is "." $new_end_date. 
		Your extend rental cost per day is $"."$extend_cost_per_day" . ", your total extend cost is $"."$extend_cost. </p>\n";
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
<title>Extend request</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<h1>IT Rental Portal</h1>
<h2>Extend Requested</h2>
<?php
if (!isset($_POST['input_day'])){
	echo "Please enter days to extend: ";
	echo "<form method='post'>";
	echo "<input type = 'text' name = 'day' value=''>";
	echo "<input type='submit' value='submit' name='input_day'>";
	echo "</form>";
}



	
	
echo $Body;
echo "<p>Return to the <a href='profilepage.php?". SID . "'> profile page.</a></p>\n";

//$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
 // echo "<br> <button class ='back'> <a href='$url'> < Back </a> </button>"; 
?>
</body>
</html>
