<?php
session_start();

require_once 'lib/utils.php';
require_once 'lib/config.php';

foreach ($_POST as $name => $value) 
	$req[$name] = trim(clean($value, 255));
	
if ($req['password'] == '' or $req['password2'] == '' or $req['alias'] == '') {
	$_SESSION['error'] = 'Required field missing.';
	myLog('BADSIGNUP', $req['alias'], 'incomplete request');
	header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
			"/signup.php");
	exit;
}

$sql_check_for_alias = "SELECT id FROM users WHERE (alias = '" . $req['alias'] . "')";
$sth_check_for_alias = @mysql_query($sql_check_for_alias);
if (@mysql_num_rows($sth_check_for_alias) > 0) {
	$_SESSION['error'] = 'Sorry, that alias already in use.';
	myLog('BADSIGNUP', $req['alias'], 'username taken');
	header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) .
			"/signup.php"); 
	exit;
}

if ($req['password'] != $req['password2']) {
	$_SESSION['error'] = 'The passwords do not match.';
	myLog('BADSIGNUP', $req['alias'], "passwords don't match");
	header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) .
			"/signup.php"); 
	exit;
}	

$req['password'] = md5(crypt($req['password'], substr($req['alias'], 0, 2)));

# add user to 'users' table
$sql_insert_user = "INSERT INTO users (alias, password, location, email, sl, site) 
		VALUES ('" . $req['alias'] . "','" . $req['password'] .  "','" . $req['location'] .  
		"','" . $req['email'] .  "'," . DEFAULT_SL . ",'" . $req['site'] .  "')";

$my_success = @mysql_query($sql_insert_user);

if (!$my_success) {
	$_SESSION['error'] = 'Database error.';
	header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) .
			"/signup.php"); 
	exit;
}

$user_id = getUserID($req['alias']);

# add user to 'stats' table
$sql_insert_stats = "INSERT INTO stats (user_id, logins, first_login, last_login) SELECT 
		id AS user_id, 1 AS logins, NOW() AS first_login, NOW() AS last_login FROM users WHERE 
		alias = '" . $req['alias'] . "'";

$sql_get_all_prefs = "SELECT p.default, p.id FROM preferences p";
$sth_get_all_prefs = @mysql_query($sql_get_all_prefs);
$sql_insert_prefs = "INSERT INTO user_preferences (user_id, pref_id, value) VALUES ";
while ($row_get_all_prefs = @mysql_fetch_assoc($sth_get_all_prefs)) {
	$sql_insert_prefs .= "(" . $user_id . ", " . $row_get_all_prefs['id'] . ", " . $row_get_all_prefs['default'] . "), ";
}
$sql_insert_prefs = rtrim($sql_insert_prefs);
$sql_insert_prefs = substr($sql_insert_prefs, 0, -1); 

$sql_get_subs = "SELECT id FROM subs";
$sth_get_subs = @mysql_query($sql_get_subs);
$sql_insert_ptrs = "INSERT INTO pointers (user_id, sub_id) VALUES ";
while ($row_get_subs = @mysql_fetch_assoc($sth_get_subs)) {
	$sql_insert_ptrs .= "(" . $user_id . ", " . $row_get_subs['id'] . "), ";
}
$sql_insert_ptrs = rtrim($sql_insert_ptrs);
$sql_insert_ptrs = substr($sql_insert_ptrs, 0, -1); 

$my_success = @mysql_query($sql_insert_stats);
if (!$my_success) {
	$_SESSION['error'] = 'Database error.';
	header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) .
			"/signup.php"); 
	exit;
}
$my_success = @mysql_query($sql_insert_prefs);
if (!$my_success) {
	$_SESSION['error'] = 'Database error.';
	header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) .
			"/signup.php"); 
	exit;
}
$my_success = @mysql_query($sql_insert_ptrs);
if (!$my_success) {
	$_SESSION['error'] = 'Database error.';
	header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) .
			"/signup.php"); 
	exit;
}
$_SESSION['alias'] = $req['alias'];
$_SESSION['sl'] = DEFAULT_SL;
$_SESSION['logged_in'] = 1;
$_SESSION['id'] = getUserID($req['alias']);
$_SESSION['sub'] = 1;

myLog('NEWUSER', $_SESSION['id']);
myLog('LOGIN', $_SESSION['id']);

header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) 
		. "/login.php?new=true");
exit;
?>