<?php

require_once 'lib/config.php';
require_once 'lib/utils.php';

session_start();
authenticate();

foreach ($_POST as $name => $value) 
	$req[$name] = trim(clean($value, 255));
	
if (!$req['topic'] or $req['topic'] == '') {
	$_SESSION['error'] = "Add topic failed.";
	header("Location: http://" . $_SERVER['HTTP_HOST'] . 	
			dirname($_SERVER['PHP_SELF']) . "/voting_booth.php" );
	exit;

}

$sql_add_topic = "INSERT INTO voting_topics (name, date) VALUES ('" . $req['topic'] . "', NOW())";
if (!@mysql_query($sql_add_topic)) {
	$_SESSION['error'] = "Add topic failed.";
	header("Location: http://" . $_SERVER['HTTP_HOST'] . 	
			dirname($_SERVER['PHP_SELF']) . "/voting_booth.php" );
	exit;
}

$sql_get_id = "SELECT id FROM voting_topics WHERE name = '" . $req['topic'] . "'";
$sth_get_id = @mysql_query($sql_get_id);
$row = @mysql_fetch_assoc($sth_get_id);
$id = $row['id'];
$sql_add_options = "INSERT INTO voting_options (topic_id, opt) VALUES ";

for ($i = 1; $i <= 10; $i++) 
	if ($req['o' . $i] != '') 
		$sql_add_options .= "($id, '" . addslashes($req['o' . $i]) . "'), ";

$sql_add_options = rtrim($sql_add_options);
$sql_add_options = substr($sql_add_options, 0, -1); 
#debug($sql_add_options); exit;

if (@mysql_query($sql_add_options)) {
	myLog('VTOPIC', $_SESSION['id'], $req['topic']);
	$_SESSION['success'] = "Topic added!";
	header("Location: http://" . $_SERVER['HTTP_HOST'] . 	
			dirname($_SERVER['PHP_SELF']) . "/voting_booth.php" );
	exit;
} else {	
	$_SESSION['error'] = "Add topic failed.";
	header("Location: http://" . $_SERVER['HTTP_HOST'] . 	
			dirname($_SERVER['PHP_SELF']) . "/voting_booth.php" );
	exit;
}
?>
