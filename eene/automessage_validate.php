<?php

require_once 'lib/utils.php';
require_once 'lib/config.php';

session_start();
authenticate();

$automessage = trim(clean($_POST['automessage'], MAXMSGLENGTH));

$sql_insert_automessage = "INSERT INTO automessages (automessage, user_id, date) VALUES ('" .
	$automessage . "', " . $_SESSION['id'] . ", NOW())";
if (@mysql_query($sql_insert_automessage)) {
	incrementStat($_SESSION['id'], 'automessages');
	myLog('AUTOMESS', $_SESSION['id']);
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/automessage.php?success=true");
	exit;
} else {
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		"/automessage.php?success=false");
	exit;
}
?>