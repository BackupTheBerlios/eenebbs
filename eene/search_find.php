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

$sql_search = "SELECT m.id, m.message, t.tagline, UNIX_TIMESTAMP(m.date) , u.alias, s.name, s.anonymous, u.id AS user_id, m.sub_id 
FROM messages m, subs s, users u
LEFT  JOIN taglines t ON t.id = m.tag_id
WHERE s.id = m.sub_id AND m.user_id = u.id AND 
MATCH ( m.message )
AGAINST ('" . $req['search'] . "')
ORDER  BY m.sub_id";

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
<tr><td>In <strong><?= $mysub ?></strong> :<br /> <span class="eene"><a href="main.php?pointer=<?= $messages[0]['id'] ?>&order=asc&sub=<?= $messages[0]['sub_id'] ?>">Read forwards from here</a> / <a href="main.php?pointer=<?= $messages[0]['id'] ?>&order=desc&sub=<?= $messages[0]['sub_id'] ?>">Read backwards from here</a></span> </td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>
<?php
		foreach ($messages as $message) {
			echo "<tr><td>";
			displayMessage($message, $message['anonymous']);
			echo "</td></tr>";
			echo "<tr><td>&nbsp;</td></tr>";
		} 
	}
?>
</table>
<?php
} else {
	$_SESSION['error'] = "No results found.";
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/search.php");
	exit;
}
?>