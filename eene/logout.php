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
</head>
<p>you are logged out.</p>
<p><a href="index.php">return to index</a></p>
<body>
</body>
</html>
