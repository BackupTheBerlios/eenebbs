<?php 

require_once 'lib/utils.php';
require_once 'lib/config.php';
session_start();

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>eeneBBS : signup</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="default.css" rel="stylesheet" type="text/css" />

</head>

<body class="main">
<?php displayErrors(); ?>
<p><a href="index.php">back to index</a></p>
<p>sure looks to me like you want to sign up for the <strong>eeneBBS</strong> 
	demo. fill out this form.</p>
<form name="signup" id="signup" method="post" action="signup_validate.php">
	<p>these three fields are <em>required</em>:<br />
		<br />
		<strong>alias:</strong> 
		<input name="alias" type="text" id="alias" />
		<br />
		<strong>password:</strong> 
		<input name="password" type="password" id="password" />
		<br />
		<strong>password (again)</strong>: 
		<input name="password2" type="password" id="password2" />
		<br />
		<br />
		the following fields are <em>optional</em>:<br />
		<br />
		<strong>email address</strong> (public): 
		<input name="email" type="text" id="email" />
		<br />
		<strong>web site</strong> (public): http:// 
		<input name="site" type="text" id="site" />
		<br />
		<strong>location</strong> (public): 
		<input name="location" type="text" id="location" />
	</p>
	<p>
		<input name="signup" type="submit" id="signup" value="sign me up mang" />
	</p>
	</form>
<p>&nbsp;</p>
</body>
</html>
