<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Create Table</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rental";

// Create connection
try {
$conn = mysqli_connect($servername, $username, $password, $dbname); }
catch ( mysqli_sql_exception $e) {
    die("Connection failed: " . mysqli_connect_error());}

//create table

// new sql setting for create table 
try{
    $conn = mysqli_connect($servername, $username, $password, $dbname); }
catch ( mysqli_sql_exception $e) {
    die("Connection failed:" . mysqli_connect_errno() . "=" . mysqli_connect_error());
}

//create table
$sql = "CREATE TABLE users
(userID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY, email VARCHAR(40), type VARCHAR(40),
password_md5 VARCHAR(32), first  VARCHAR(40), last VARCHAR(40), phone INT(10))";
		

$sql_2 = "CREATE TABLE available_rental 
(rentID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
category VARCHAR(40), brand VARCHAR(25), description VARCHAR(50), 
regular_cost VARCHAR(30), extend_cost VARCHAR(30), status VARCHAR(20) DEFAULT 'Available', rentUser VARCHAR(30) DEFAULT NULL, 
start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL)";	
#$sql_3 = "CREATE TABLE assigned_oppotunities (rentID SMALLINT, userID SMALLINT, date_selected DATE, date_approved DATE) ";

$sql_4 = "CREATE TABLE start_rent (currentID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY, rentID SMALLINT, userID SMALLINT, email VARCHAR(40), start_date DATE, end_date DATE) ";
$sql_5 = "CREATE TABLE rent_history (rentID SMALLINT, rentUser VARCHAR(40), category VARCHAR(40), brand VARCHAR(40), start_date DATE, end_date DATE) ";
try {
    mysqli_query($conn, $sql);
	mysqli_query($conn, $sql_2);
	mysqli_query($conn, $sql_4);
	mysqli_query($conn, $sql_5);
    echo "'users', 'available_rental', 'start_rent', 'rent_history' Tables created successfully <br>";
}
catch (mysqli_sql_exception $e){
     die("Error creating tables: " . mysqli_error($conn));}





mysqli_close($conn);


?>
</body>
</html>
