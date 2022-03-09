
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>verify login</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<h1>IT Rental Portal</h1>
<h2>Profile page</h2>

<?php
$errors = 0;
$DBName = "rental";
try {
	#initialize mysql connection
    $conn = @mysqli_connect("localhost", "root", "",$DBName );
    
    $TableName = "users";
	#sql select statement
    $SQLstring = "SELECT userID, type, first, last, email FROM $TableName" . " where email='" . stripslashes($_POST['email']) ."' and password_md5='" . md5(stripslashes($_POST['password'])) . "'";
    $qRes = @mysqli_query($conn, $SQLstring);
	
	#If the statement returned nothing (Check if email and password is correct)
    if (mysqli_num_rows($qRes)==0) {
        echo "<p>The e-mail address/password " . " combination entered is not valid. </p>\n";
        ++$errors;
    }
    else {
		#if user entered correct email + password 
		#start session
		session_start();
		
		#Set query results into a single associate array
        $Row = mysqli_fetch_assoc($qRes);
		
		#Assign session variables 
        $UserID = $Row['userID'];
		$Email_db = $Row['email'];
        $Name = $Row['first'] . " " . $Row['last'];
		$Role = $Row['type'];
		$Email = $_POST['email'];
        echo "<p>Welcome back, $Name!</p>\n";
		$_SESSION['role'] = $Role;
        $_SESSION['userID'] = $UserID;
		$_SESSION['email'] = $Email;
		echo "<p>You are logged in as $Email</p>\n";
		echo "Your role is $Role";
		
		#redirect to profile page
		header("Location: profilepage.php");
		exit();
		
    }
}
catch(mysqli_sql_exception $e) {
	#catch error 
    echo "<p>Error: unable to connect/insert record in the database.</p>";
    ++$errors;
}


?>
</body>
</html>
