<?php

require_once 'lib/utils.php';
session_start();
authenticate();

foreach ($_POST as $name => $value) 
	$req[$name] = trim(clean($value, 255));
	
if (!isset($req['old1']) or !isset($req['old2']) or !isset($req['new1']) or !isset($req['new2'])) {
	$_SESSION['error'] = "Please complete all fields.";
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/passwd.php");
	exit;
}

if ($req['old1'] == $req['old2'] and $req['new1'] == $req['new2']) {
	if ($req['old1'] == $req['new1']) {
		$_SESSION['error'] = "New and old passwords are the same.";
		header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/passwd.php");
		exit;
	}
	$sql_check_pw = "SELECT password FROM users WHERE id = " . $_SESSION['id'];
	$sth_check_pw = @mysql_query($sql_check_pw);
	$row_check_pw = @mysql_fetch_assoc($sth_check_pw);
	if ($row_check_pw['password'] != md5(crypt($req['old1'], substr($_SESSION['alias'], 0, 2)))) {
		$_SESSION['error'] = "Old password does not match current password.";
		header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/passwd.php");
		exit;
	}
	$sql_change_pw = "UPDATE users SET password = '" . md5(crypt($req['new1'], substr($_SESSION['alias'], 0, 2))) . "' WHERE id = " . $_SESSION['id'];
	if (@mysql_query($sql_change_pw)) {
		$_SESSION['success'] = "Password successfully changed.";
		header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/passwd.php");
		exit;	

	}
}

$_SESSION['error'] = "Unknown error occurred.";
header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/passwd.php");
exit;	

?>