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
	
$sql_users = "UPDATE users SET location = '" . $req['location'] .
		"', email = '" . $req['email'] . "', site = '" . $req['site'] . 
		"' WHERE id = " . $_SESSION['id'];

$my_success = mysql_query($sql_users);

#debug($req);exit;

if ($user_prefs = getUserPrefs($_SESSION['id'])) {
	foreach ($user_prefs as $user_pref => $value) {
		if ($pref_types[$user_pref] == 'bit' or isset($req['p' . $user_pref])) {
			$value = @$req['p' . $user_pref];
			switch($pref_types[$user_pref]) {
				case 'bit':
					$value = ($value) ? 1 : 0;
					break;
				default:
					$value = "'" . $req['p' . $user_pref] . "'";
					break;
				case 'enum';
					$value = $req['p' . $user_pref];
			}
			$sql_update_user_prefs = "UPDATE user_preferences SET value = " . $value . 
					" WHERE user_id = " . $_SESSION['id'] .	" AND pref_id = " . $user_pref;
		}
		$my_success = @mysql_query($sql_update_user_prefs);
	}
}

if ($my_success) 
	$_SESSION['success'] = "Preferences saved.";
else
	$_SESSION['error'] = "Save failed.";
	
header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		"/prefs.php");
exit;

?>