<?php

require_once 'lib/utils.php';
require_once 'lib/config.php';
session_start();
authenticate();

foreach ($_POST as $name => $value) 
	$req[$name] = trim(clean($value, 64));
foreach ($_GET as $name => $value) 
	$req[$name] = trim(clean($value, 16));

if (isset($req['sub']))
	$_SESSION['sub'] = $req['sub'];
$main_params = $_SERVER['QUERY_STRING'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title><?= BBSNAME ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<frameset cols="*,165" frameborder="NO" border="0" framespacing="0">
	<frame src="main.php?<?= $main_params ?>" name="mainFrame">
	<frame src="nav_frame.php" name="rightFrame" noresize="noresize"  marginwidth="0" marginheight="0">
</frameset>
<noframes><body class="main">
Sorry, your browser must support frames!
</body></noframes>
</html>
