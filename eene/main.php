<?php 

require_once 'lib/config.php';
require_once 'lib/utils.php';

session_start();
authenticate();

function _loopMsgs($sth_msgs, $pointer = null, $anonymous = null) {
	if (!$pointer) $pointer = 0;
	while ($row_msgs = @mysql_fetch_assoc($sth_msgs)) {
		displayMessage($row_msgs, $anonymous);
		echo "<tr><td>&nbsp;</td></tr>";
		$pointer = $row_msgs['id'];
	}	
	return $pointer;
}

function getNextSub() {
	$sql_get_next = "SELECT id FROM subs WHERE id > " . $_SESSION['sub'] .  " ORDER BY id ASC LIMIT 1";
	if ($sth_get_next = @mysql_query($sql_get_next) and mysql_num_rows($sth_get_next) > 0) {
		$row_get_next = @mysql_fetch_assoc($sth_get_next);
	} else {
		$row_get_next['id'] = 1;
	}	
	return $row_get_next['id'];
}

foreach ($_GET as $name => $value) 
	$req[$name] = trim(clean($value, 255));
foreach ($_POST as $name => $value) 
	$req[$name] = trim(clean($value, 255));

if (isset($req['sub'])) {
	$_SESSION['sub'] = $req['sub'];
} else if (isset($req['login'])) {
	$req['sub'] = $_SESSION['sub'];
} else if (isset($req['newscan']) and !isset($req['sub']) and !isset($req['current'])) {
	$req['sub'] = getNextSub();
	$_SESSION['sub'] = getNextSub();
}
$sql_sub = "SELECT name, anonymous FROM subs WHERE id = " . $_SESSION['sub'];
$sth_sub = @mysql_query($sql_sub);
$row_sub = @mysql_fetch_assoc($sth_sub);
$sub = $row_sub['name'];
$anonymous = $row_sub['anonymous'];

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="default.css" rel="stylesheet" type="text/css">
<title><?= BBSNAME ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<body class="text">
<?php 
if (isset($req['login'])) {
	if (isset($req['new']))
		echo "<p>you are a n00b.</p>";
	if (getUserPrefs($_SESSION['id'], 'DISP_LASTUSERS')) {
?>
<hr noshade>
<p>Last 5 users:</p>
<ul>
<?php

		$sql_last_logins = "SELECT u.alias, UNIX_TIMESTAMP(l.date) FROM log l, 
			users u WHERE l.event_id = 3 AND u.id = l.user_id ORDER BY l.date DESC LIMIT 5";
		$sth_last_logins = @mysql_query($sql_last_logins);
		
		while ($row_last_logins = mysql_fetch_assoc($sth_last_logins)) {
			$time = date("F j, Y, g:i a", $row_last_logins['UNIX_TIMESTAMP(l.date)']); 
?>
	<li><?= $row_last_logins['alias'] ?> : <?= $time ?></li>
<?php
		}
?>
</ul>
<?php
	}

	if (getUserPrefs($_SESSION['id'], 'DISP_AUTOMESS')) {
		echo "<hr noshade>";
		echo getAutomessage();	
		echo "<hr noshade>";
	}
}
?>
<p class="subName">/ <?= $sub ?> /</p>
<table class="msgTable">
<?php

if (isset($req['sub'])) {
	if (isset($req['newscan'])) {
		$pointer = getPointer($_SESSION['sub'], $_SESSION['id']);
		$sth_msgs = getNewMessages($_SESSION['sub'], $pointer);
		$new_pointer = _loopMsgs($sth_msgs, $pointer, $anonymous);
		setPointer($_SESSION['sub'], $_SESSION['id'], $new_pointer);
	} elseif (isset($req['order']) and $req['order'] == 'desc') {
		$sth_msgs = getMessages($_SESSION['sub'], true);
		_loopMsgs($sth_msgs, null, $anonymous);
	} else {
		$sth_msgs = getMessages($_SESSION['sub']);
		_loopMsgs($sth_msgs, null, $anonymous);
	}
}

?>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td bgcolor="#BBBBBB"><table width="100%" border="0" cellpadding="4" cellspacing="1">
				<tr> 
					<td class="navbarTable"><strong> / 
						<?= $sub ?>
						/ </strong></td>
				</tr>
				<tr> 
					<td class="navbarTable"><a href="post.php?sub=<?= $_SESSION['sub'] ?>"><strong>Post 
						a Message</strong></a> / <a href="main.php?order=asc">Read Forwards</a> 
						/ <a href="main.php?order=desc">Read Backwards</a> / <a href="main.php?newscan=true&sub=<?= getNextSub() ?>"><strong>Newscan 
						Next Sub</strong></a></td>
				</tr>
				<?php
if ($_SESSION['sl'] == SYSOP_SL) {
?>
				<?php
}
?>
			</table></td>
	</tr>
</table>
</body>
</html>
