<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Create DATABASE</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rental";

// Create connection
try{
    $conn = mysqli_connect($servername, $username, $password); }
catch ( mysqli_sql_exception $e) {
    die("Connection failed:" . mysqli_connect_errno() . "=" . mysqli_connect_error());
}

// Create database

$sql = "CREATE DATABASE online_stores";
try {
    mysqli_query($conn, $sql);  //pre PHP8.1 - if (mysqli_query($conn, $sql))
    echo "Database created successfully"; }
catch(mysqli_sql_exception $e) {
    die("Error creating database: " . mysqli_error($conn)); }




/*
//Drop database
$sql = "DROP DATABASE myDB1";
try {
    mysqli_query($conn, $sql);
    echo"Database deleted successfully";   
 }
catch(mysqli_sql_exception $e){
    die( "Error deleting database: " . mysqli_errno($conn). " - " . mysqli_error($conn));}
*/
 

    
mysqli_close($conn);
?>
</body>
</html>
