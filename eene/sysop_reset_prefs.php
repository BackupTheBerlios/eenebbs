<?php

require_once 'lib/config.php';
require_once 'lib/utils.php';
authenticate();
authenticateSysop();

$sql_get_all_users = "SELECT u.id from users u";
$sth_get_all_users = mysql_query($sql_get_all_users);
while ($row_get_all_users = @mysql_fetch_assoc($sth_get_all_users)) {
	$user_id = $row_get_all_users['id'];
	$sql_get_all_prefs = "SELECT p.default, p.id FROM preferences p";
	$sth_get_all_prefs = @mysql_query($sql_get_all_prefs);
	$sql_insert_prefs = "INSERT INTO user_preferences (user_id, pref_id, value) VALUES ";
	while ($row_get_all_prefs = @mysql_fetch_assoc($sth_get_all_prefs)) {
		$sql_insert_prefs .= "(" . $user_id . ", " . $row_get_all_prefs['id'] . ", " . $row_get_all_prefs['default'] . "), ";
	}
	$sql_insert_prefs = rtrim($sql_insert_prefs);
	$sql_insert_prefs = substr($sql_insert_prefs, 0, -1); 
	echo mysql_query($sql_insert_prefs);
}
?>