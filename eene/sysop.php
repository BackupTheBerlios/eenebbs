<?php 

require_once 'lib/config.php';
require_once 'lib/utils.php';
session_start();
authenticate();
authenticateSysop();

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= BBSNAME ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="default.css" rel="stylesheet" type="text/css">
</head>

<body class="main">

<p>w00t it's the sysop menu. here's what you can do:</p>
<p><a href="sysop_log.php">view system log</a></p>
</body>
</html>
