<?php

require_once 'lib/utils.php';
require_once 'lib/config.php';

session_start();
authenticate();

$automessage = trim(cleanAllowImg($_POST['automessage'], MAXMSGLENGTH));

foreach ($_POST as $name => $value) 
	$req[$name] = trim(clean($value, 255));

$sql_insert_automessage = "INSERT INTO automessages (automessage, user_id, date) VALUES ('" .
	$automessage . "', " . $_SESSION['id'] . ", NOW())";
if (@mysql_query($sql_insert_automessage)) {
	incrementStat($_SESSION['id'], 'automessages')
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		"/automessage.php?success=true");
	exit;
} else {
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		"/automessage.php?success=false");
	exit;
}
?>