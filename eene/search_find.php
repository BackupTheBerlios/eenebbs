<?php

require_once 'lib/utils.php';
session_start();
authenticate();

foreach ($_POST as $name => $value) 
	$req[$name] = trim(clean($value, 255));
	
if (!isset($req['search']) or $req['search'] == '') {
	$_SESSION['error'] = "Your search text was empty.";
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/search.php");
	exit;
}

$sql_search = "SELECT m.* , s.name
		FROM messages m, subs s
		WHERE s.id = m.sub_id AND 
		MATCH ( m.message )
		AGAINST ('" . $req['search'] . "' ) ORDER BY m.sub_id";
$sth_search = @mysql_query($sql_search);
if (@mysql_num_rows($sth_search) > 0) {

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= BBSNAME ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>
<body class="main">
<p><a href="search.php">Back to Search</a></p>
<p>Here are your results:</p>
<table class="msgTable">
<?php
	$messages = array();
	while ($row_search = @mysql_fetch_assoc($sth_search)) {
		$subs[$row_search['name']][] = $row_search;
	}
	foreach ($subs as $mysub => $messages) {
?>
<tr><td>In <strong><a href="main.php&pointer=<?= $messages[0]['id'] ?>&order=asc&sub=<?= $messages[0]['sub_id'] ?>"><?= $mysub ?></a></strong></td></tr>
<?php
		foreach ($messages as $message) {
			displayMessage($message, $message['anonymous']);
			echo "<tr><td>&nbsp;</td></tr>";
		} 
	}
	echo "</table>";
} else {
	$_SESSION['error'] = "No results found.";
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/search.php");
	exit;
}
?>