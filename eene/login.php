<?php

require_once 'lib/utils.php';
require_once 'lib/config.php';

session_start();

foreach ($_POST as $name => $value) 
	$req[$name] = trim(clean($value, 255));
	
/* if $req['new'] is set then we should have some session vars.
*/
if (isset($_SESSION['alias']) and isset($_SESSION['logged_in']) and 
		!isset($req['alias']) and !isset($req['password'])) {		
	if (isset($_GET['new']))
		header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
				"/main_frames.php?login=true&new=true");
	else 
		header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
				"/main_frames.php?login=true");
	exit;
}
/* otherwise ... 
*/

if (!isset($req['alias']) or !isset($req['password'])) {
	myLog('BADPW', getUserID($req['alias']), $req['password']);
	$_SESSION['error'] = "Bad user name and/or password.";
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']));
  exit;
}

$sql_check_password = "SELECT id, password, sl FROM users WHERE alias = '" . 
		$req['alias'] . "'";
$sth_check_password = @mysql_query($sql_check_password);
if ($sth_check_password) {
	$row = @mysql_fetch_assoc($sth_check_password);
	if (md5(crypt($req['password'], substr($req['alias'], 0, 2))) == $row['password']) {
		$_SESSION['alias'] = $req['alias'];
		$_SESSION['id'] = $row['id'];
		$_SESSION['logged_in'] = 1;
		$_SESSION['sl'] = $row['sl'];
		$_SESSION['sub'] = 1;
		incrementStat($row['id'], 'logins');
		myLog('LOGIN', $row['id']);
		header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
				"/main_frames.php?login=true&newscan=true");
		exit;
	} else {
		myLog('BADPW', getUserID($req['alias']), $req['password']);
		$_SESSION['error'] = "Bad user name and/or password.";	
		header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']));
		exit;
	}
} 
$_SESSION['error'] = "Bad user name and/or password.";
myLog('BADPW', getUserID($req['alias']), $req['password']);
header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']));

?>