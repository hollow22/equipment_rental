<?php
session_start();
$_SESSION = array();
session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
.textbox
{
	position: absolute;
   
	left: 200px;
}
</style>
<title>LogIn</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<h1>IT Rental Portal</h1>
<h2>Log In</h2>

<hr />
<h3>Existing User Login</h3>
<form method="post" action="VerifyLogin.php" >
<p>E-mail address: <input type="text" class="textbox" name="email" /></p>
<p>Password: <input type="password" class="textbox" name="password" /></p>


<input type="submit" name="login" class="textbox" value="Log In" />
</form>

<?php 
echo "<br>";
echo "<hr />";
echo "<br>New user?  <a href='UserRegister.php'> Click here</a> to Register";

?>

</body>
</html>
