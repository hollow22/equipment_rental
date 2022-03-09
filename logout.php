<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>


</style>

<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>


<form method ='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
<?php 

echo "<hr>";
echo "<p> <input type = 'submit' value = 'Logout' name = 'logout'> </input></p>\n";

echo "</form>";

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
</div>
</body>
</html>