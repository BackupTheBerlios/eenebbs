<?php

require_once 'lib/config.php';
require_once 'lib/utils.php';
session_start();
authenticate();

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>
<?php

if (isset($_GET['success']) and $_GET['success'] = 'true') {
?>
<body class="main" onload="parent.rightFrame.location.reload(true);">
<?php
} else {
	echo "<body class=\"main\">";
}
?>
<p>here j00 can ad teh sub. don't make no dum subs dig.</p>
<p>max length is like 64 characters but try and keep it under 16, shit.</p>
<form name="form1" id="form1" method="post" action="addsub_validate.php">
	New sub name: 
	<input name="sub" type="text" id="sub" maxlength="64" />
	<input type="submit" name="Submit" value="a noo subbbb" />
</form>
<p>&nbsp;</p>
</body>
</html>
