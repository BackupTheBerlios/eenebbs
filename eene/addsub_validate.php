<?php

require_once 'lib/utils.php';
require_once 'lib/config.php';

session_start();
authenticate();

foreach ($_POST as $name => $value) 
	$req[$name] = trim(clean($value, 64));

if (isset($req['sub'])) {
	$sql_insert_sub = "INSERT INTO subs (name, created_by_user_id) 
			VALUES ('" . $req['sub'] . "', " . $_SESSION['id'] . ")";
	if (@mysql_query($sql_insert_sub)) {
		incrementStat($_SESSION['id'], 'subs');
		header("Location: http://" .$_SERVER['HTTP_HOST'] .
		 		dirname($_SERVER['PHP_SELF']) . 
		 		"/addsub.php?success=true");
		exit;
	}
} 
header("Location: http://" .$_SERVER['HTTP_HOST'] . 				
		dirname($_SERVER['PHP_SELF']) . "/addsub.php?success=false");
exit;

?>