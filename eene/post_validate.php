<?php

require_once 'lib/utils.php';
require_once 'lib/config.php';

session_start();
authenticate();

$message = trim(cleanAllowImg($_POST['message'], MAXMSGLENGTH));
if ($message == '' or !$message) {
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		"/main.php?success=false");
	exit;
}

/*
foreach ($_POST as $name => $value) 
	$req[$name] = trim(clean($value, 255));
*/

$sql_post = "INSERT INTO messages (sub_id, user_id, message, date) VALUES (" . $_SESSION['sub'] .
		", " . $_SESSION['id'] . ", '" . $message . "', NOW())";
if (@mysql_query($sql_post)) {
	incrementStat($_SESSION['id'], 'posts');
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		"/main.php?success=true&newscan=true&current=true&sub=" . $_SESSION['sub']);
	exit;
} else {
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		"/main.php?success=false&newscan=true&current=true&sub=" . $_SESSION['sub']);
	exit;
}
?>