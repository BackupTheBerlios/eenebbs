<?php 

require_once 'lib/config.php';
require_once 'lib/utils.php';
session_start();
authenticate();

$sql_get_num_mottos = "SELECT COUNT(motto) FROM mottos";
$row = @mysql_fetch_assoc(@mysql_query($sql_get_num_mottos));

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>
<body class="main">

<p>There are currently <?= $row['COUNT(motto)']; ?> mottos.</p>
<p>So you want to add a motto. Max length 255 chars.</p>
<form name="form1" id="form1" method="post" action="motto_add.php">
	<input name="motto" type="text" id="motto" size="64" maxlength="255" />
	<br />
	<input type="submit" name="Submit" value="FUCK" />
</form>
<p>&nbsp; </p>
</body>
</html>
