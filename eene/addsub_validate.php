<?php

require_once 'lib/utils.php';
require_once 'lib/config.php';

session_start();
authenticate();

foreach ($_POST as $name => $value) 
	$req[$name] = trim(clean($value, 64));

if (isset($req['sub'])) {
	$sql_insert_sub = "INSERT INTO subs (name, created_by_user_id) 
			VALUES ('" .$req['sub'] . "', " . $_SESSION['id'] . ")";
	@mysql_query($sql_insert_sub);
	$sql_get_sub_id = "SELECT id FROM subs WHERE name = '" . $req['sub'] . "'";
	$sth_get_sub_id = @mysql_query($sql_get_sub_id);
	$row_get_sub_id = @mysql_fetch_assoc($sth_get_sub_id);
	$sub_id = $row_get_sub_id['id'];
	$sql_get_users = "SELECT id FROM users";
	$sth_get_users = @mysql_query($sql_get_users);
	$sql_insert_ptrs = "INSERT INTO pointers (user_id, sub_id) VALUES ";
	while ($row_get_users = @mysql_fetch_assoc($sth_get_users)) {
		$sql_insert_ptrs .= "(" . $row_get_users['id'] . "," . $sub_id . "), ";
	}
	$sql_insert_ptrs = rtrim($sql_insert_ptrs);
	$sql_insert_ptrs = substr($sql_insert_ptrs, 0, -1);
	if ($sth_insert_ptrs = @mysql_query($sql_insert_ptrs)) {
		incrementStat($_SESSION['id'], 'subs');
		myLog('NEWSUB', $_SESSION['id'], $req['sub']);
		$_SESSION['success'] = "Sub added!";
		header("Location: http://" .$_SERVER['HTTP_HOST'] .
 				dirname($_SERVER['PHP_SELF']) . "/addsub.php");
		exit;
	}
} 
$_SESSION['error'] = "Could not add sub.";
header("Location: http://" .$_SERVER['HTTP_HOST'] . 				
		dirname($_SERVER['PHP_SELF']) . "/addsub.php");
exit;

?>