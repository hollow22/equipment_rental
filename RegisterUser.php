<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>LogIn/REGISTER</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<h1>IT Rental Portal</h1>
<h2>User Registration</h2>

<?php
//$Body = "";
$errors = 0;
$email = "";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rental";

// Create connection
try{
    $conn = mysqli_connect($servername, $username, $password, $dbname); }
catch ( mysqli_sql_exception $e) {
    die("Connection failed:" . mysqli_connect_errno() . "=" . mysqli_connect_error());
}

#check email field
if (empty($_POST['email'])) {
	++$errors;
	echo "<p>You need to enter an e-mail address.</p>\n";
	}
else {
	$email = stripslashes($_POST['email']);
	#Check email matches the email format with preg match
	if (preg_match("/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)*(\.[a-z]{2,3})$/i", $email) == 0) {
		
		++$errors;
		echo "<p>You need to enter a valid " . "e-mail address.</p>\n";
		$email = "";
	}
}

#check phone field
if (empty($_POST['phone'])) {
	++$errors;
	echo "<p>You need to enter a phone number.</p>\n"; 
	$phone = "";
}
else
	$phone = stripslashes($_POST['phone']);

#check password field
if (empty($_POST['password'])) {
	++$errors;
	echo "<p>You need to enter a password.</p>\n"; 
	$password = "";
}
else
	$password = stripslashes($_POST['password']);

#check second password field
if (empty($_POST['password2'])) {
	++$errors;
	echo "<p>You need to enter a confirmation password.</p>\n";
	$password2 = "";
}
else
	$password2 = stripslashes($_POST['password2']);

#Check if both passwords equals to each other
if ((!(empty($password))) && (!(empty($password2)))) {
	if (strlen($password) < 6) {
		++$errors;
		echo "<p>The password is too short.</p>\n";
		$password = "";
		$password2 = "";
	}
	if ($password <> $password2) {
		++$errors;
		echo "<p>The passwords do not match.</p>\n";
		$password = "";
		$password2 = "";
	}
}

#if no errors, initialize sql database connection
if ($errors == 0) {
	#$conn = @mysqli_connect ("localhost", "root", "mysql");
	if ($conn === FALSE) {
		echo "<p>Unable to connect to the database server. " . "Error code " . mysqli_connect_errno() . ": " . mysqli_connect_error() . "</p>\n";
		++$errors;
	}
	else {
		$DBName = "rental";
		$result = @mysqli_select_db($conn,$DBName);
		if ($result === FALSE) {
			echo "<p>Unable to select the database. " . "Error code " . mysqli_errno($conn) . ": " . mysqli_error($conn) . "</p>\n";
			++$errors;
		}
	}
}

#check if user exist in database 
$TableName = "users";
if ($errors == 0) {
	#sql statement
	$sql = "SELECT count(*) FROM $TableName" . " where email='" . $email . "'";
	#sql query
	$qRes = @mysqli_query($conn, $sql);
	if ($qRes != FALSE) {
		$Row = mysqli_fetch_row($qRes);
		if ($Row[0]>0) {
			echo "<p>The email address entered (" . htmlentities($email) . ") is already registered.</p>\n";
			++$errors;
		}
	}
}
if ($errors > 0) {
	#echo "<p>Please use your browser's BACK button to return" . " to the form and fix the errors indicated.</p>\n";
	$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
  echo "<br> <button class ='back'> <a href='$url'> < Back </a> </button>"; 
}

#Insert the user details into sql database 
if ($errors == 0) {
	$first = stripslashes($_POST['first']);
	$last = stripslashes($_POST['last']); 
	$type = $_POST['type'];
	#sql statement 
	$sql = "INSERT INTO $TableName " . " (first, last, phone, type, email, password_md5) " . " VALUES( '$first', '$last', '$phone', '$type', '$email', " . " '" . md5($password) . "')";
	#sql query
	$qRes = @mysqli_query($conn, $sql);
	if ($qRes === FALSE) {
		#unable to save user details for some reason
		echo "<p>Unable to save your registration " . " information. Error code " . mysqli_errno($conn) . ": " . mysqli_error($conn) . "</p>\n";
		++$errors;
	}
	else {
		$UserID = mysqli_insert_id($conn);
		$_SESSION['userID'] = $UserID;

	}
	mysqli_close($conn);
}
if ($errors == 0) {
	#$UserName = $first . " " . $last;
	$email = $_POST['email'];
	echo "Your User ID is <strong>" . $_SESSION['userID'] . "</strong>.</p>\n";
	echo "<p>Thank you for creating an account! Use $email as user name to login!";
	
	
}

if ($errors == 0) {
	#Redirect to login page
	echo "<p><a href='UserLogin.php?" . SID . "'>Login now</a></p>\n";
}
?>

</body>
</html>
