<?php

require_once 'lib/utils.php';
session_start();
authenticate();

foreach ($_POST as $name => $value) 
	$req[$name] = trim(clean($value, 255));
	
if (!isset($req['motto']) or $req['motto'] == '') {
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/motto.php?badmotto=true");
	exit;
}

$req['motto'] = clean($req['motto'], 255);
$sql_put_motto = "INSERT INTO mottos (motto) VALUES ('" . $req['motto'] . "')";

if ( @mysql_query($sql_put_motto) ) {
	myLog('MOTTO', $_SESSION['id'], $req['motto']);
	incrementStat($_SESSION['id'], 'mottos');
	$_SESSION['success'] = "Motto added!";
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/motto.php");
	exit;	
} else {
	$_SESSION['error'] = "Could not add motto.";
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/motto.php");
	exit;
}
?>