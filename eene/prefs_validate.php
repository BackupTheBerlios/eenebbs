<?php

require_once 'lib/utils.php';
require_once 'lib/config.php';

session_start();
authenticate();

$success = false;

$req = array();
foreach ($_POST as $name => $value) 
	$req[$name] = trim(clean($value, 255));

$sql_get_prefs = "SELECT id, type FROM preferences";
$sth_get_prefs = mysql_query($sql_get_prefs);
$pref_types = array();
while ($row_get_prefs = mysql_fetch_assoc($sth_get_prefs)) 
	$pref_types[$row_get_prefs['id']] = $row_get_prefs['type'];
	
$sql_users = "UPDATE users SET location = '" . $req['location'] . "', email = '" . $req['email'] . "', 
		avatar = '" . $req['avatar'] . "', site = '" . $req['site'] . "' WHERE id = " . $_SESSION['id'];

unset($req['Submit']);
unset($req['email']);;
unset($req['site']);
unset($req['avatar']);
unset($req['location']);

$success = @mysql_query($sql_users);

if ($user_prefs = getUserPrefs($_SESSION['id'])) {
	foreach ($user_prefs as $user_pref => $value) {
		$sql_update_user_prefs = '';
		if ($pref_types[$user_pref] == 'bit' or isset($req['p' . $user_pref])) {
			$value = @$req['p' . $user_pref];
			switch($pref_types[$user_pref]) {
				case 'num':
					break;
				case 'bit':
					$value = ($value) ? "'Y'" : "'N'";
					break;
				default:
					$value = "'" . $req['p' . $user_pref] . "'";
			}
			$sql_update_user_prefs = "UPDATE user_preferences SET value = " . $value . 
					" WHERE user_id = " . $_SESSION['id'] .	" AND pref_id = " . $user_pref;
			unset($req['p' . $user_pref]);
		}
		$success = mysql_query($sql_update_user_prefs);
	}
}

if ($req) {
	$sql_insert_user_prefs = "INSERT INTO user_preferences (user_id, pref_id, value) VALUES ";
	foreach ($req as $pref_id => $value) {
		$id = substr($pref_id, 1);
		switch ($pref_types[$id]) {
			case 'num':
				break;
			case 'bit': 
				$value = "'Y'";
				break;
			default:
				$value = "'" . $value . "'";
		}							
		$sql_insert_user_prefs .= "(" . $_SESSION['id'] . ", " . $id . 
				", " . $value . "), "; 
	}
	$sql_insert_user_prefs = rtrim($sql_insert_user_prefs);
	$sql_insert_user_prefs = substr($sql_insert_user_prefs, 0, -1); 
	$success = @mysql_query($sql_insert_user_prefs);
}

header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		"/prefs.php?success=" . $success);
exit;

?>