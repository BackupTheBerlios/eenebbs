<?php 
session_start();
require_once 'lib/config.php';
require_once 'lib/utils.php';


echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="default.css" rel="stylesheet" type="text/css" />
</head>
<body class="main">

<p>ok so here is the current automessage :</p>
<?= getAutomessage();?>
<p>you can change the automessage here</p>
<form action="automessage_validate.php" method="post">
	<textarea name="automessage" cols="64" rows="5" id="automessage"></textarea>
	<br />
	<input name="submit" type="submit" id="submit" value="change teh automessage" />
</form>
</body>
</html>
