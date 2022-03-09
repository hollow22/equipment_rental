<?php
session_start();
$_SESSION = array();
session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<style>
.form {
	
  margin-top: 100px;
  margin-bottom: 100px;
  margin-right: 150px;
  margin-left: 600px;
  
}

.textbox
{
	position: absolute;
   
	right: 800px;
}

.selecttbox
{
	position: absolute;
   
	right: 910px;
}
	

</style>
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Register</title>
<center>
<h1>IT Rental Portal</h1>
</center>
</head>
<body>

<form method="post" action="RegisterUser.php" class ="form">
<h3>New user Registration</h3>

<p><label> First Name: </label> <input type="text" class = "textbox" name="first" /></p>
<label> Last Name: </label> <input type="text" class = "textbox" name="last" /> <br></br>
<label> Phone: </label> <input type="text" class = "textbox" name="phone" /> <br></br>
<label for="type">Account type: </label> 
<select name ="type" id="type" class = "selecttbox"> 
<option value="admin"> Admin </option>
<option value="client"> Client </option>
</select>
<p>E-mail address: <input type="text" class = "textbox" name="email" /></p>
<p>Password: <input type="password" class = "textbox"name="password" /></p>
<p>Confirm your password: <input type="password" class = "textbox"name="password2" /></p>
<p><em>(Passwords are case-sensitive and must be at least 6 characters long)</em></p>
<input type="reset" name="reset" value="Reset Registration Form" />
<input type="submit" name="register" value="Register" />
</form>

</body>
</html>
