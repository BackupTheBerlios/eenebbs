<?php
session_start();

require_once 'lib/utils.php';
require_once 'lib/config.php';

foreach ($_POST as $name => $value) 
	$req[$name] = trim(clean($value, 255));
	
if (!isset($req['password']) and !isset($req['alias'])) {
	header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/signup.php?missing=true");
	exit;
}

$sql_check_for_alias = "SELECT id FROM users WHERE (alias = '" . $req['alias'] . "')";
$sth_check_for_alias = @mysql_query($sql_check_for_alias);
if (@mysql_num_rows($sth_check_for_alias) > 0) {
	header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/signup.php?taken=true"); 
	exit;
}

$req['password'] = md5(crypt($req['password'], substr($req['alias'], 0, 2)));

# add user to 'users' table
$sql_insert_user = "INSERT INTO users (alias, password, location, email, avatar, sl, site) 
		VALUES ('" . $req['alias'] . "','" . $req['password'] .  "','" . $req['location'] .  
		"','" . $req['email'] .  "','" . $req['avatar'] . "'," . DEFAULT_SL . ",'" . $req['site'] .  "')";

@mysql_query($sql_insert_user);

# add user to 'stats' table
$sql_insert_stats = "INSERT INTO stats (user_id, logins, first_login, last_login) SELECT 
		id AS user_id, 1 AS logins, NOW() AS first_login, NOW() AS last_login FROM users WHERE 
		alias = '" . $req['alias'] . "'";

@mysql_query($sql_insert_stats);

/* add user to 'prefs' table
$sql_insert_prefs = "INSERT INTO preferences (user_id, display_automessage) SELECT id AS 
		user_id, 'Y' AS display_automessage FROM users WHERE alias = '" . $req['alias'] . "'";

@mysql_query($sql_insert_prefs);
*/

$_SESSION['alias'] = $req['alias'];
$_SESSION['sl'] = DEFAULT_SL;
$_SESSION['logged_in'] = 1;
$_SESSION['id'] = getUserID($req['alias']);
myLog('NEWUSER', $_SESSION['id']);
myLog('LOGIN', $_SESSION['id']);

header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/login.php?new=true");
exit;
?>