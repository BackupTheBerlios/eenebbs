<?php

require_once 'lib/utils.php';
require_once 'lib/config.php';
session_start();
myLog('LOGOUT', $_SESSION['id']);
$_SESSION['logged_in'] = null;
unset($_SESSION['logged_in']);
$_SESSION['alias'] = null;
unset($_SESSION['alias']);

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>
<body class="main">
<p>you are logged out.</p>
<hr noshade />
<p>you can <a href="signup.php">sign up</a> or log in below: </p>
<form action="login.php" method="post" name="login" id="login">
	<strong>alias</strong>: 
	<input name="alias" type="text" id="alias"><br />
	<strong>password</strong>: 
	<input name="password" type="password" id="password" />
	<br>
	<input name="login" type="submit" id="login" value="login" />
</form>

</body>
</html>
