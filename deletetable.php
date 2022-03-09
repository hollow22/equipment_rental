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

//delete table

try {
    mysqli_query($conn, "Drop Table users");
	mysqli_query($conn, "Drop Table available_rental");
	mysqli_query($conn, "Drop Table start_rent");
	mysqli_query($conn, "Drop Table rent_history");
    echo " Tables deleted successfully <br>";
}
catch (mysqli_sql_exception $e){
     die("Error in dropping tables: " . mysqli_error($conn));}





mysqli_close($conn);


?>
</body>
</html>
