<?php 

require_once 'lib/config.php';
require_once 'lib/utils.php';

session_start();
authenticate();

function _setPointer($sub_id, $user_id, $pointer) {
	$sql_set_ptr = "UPDATE pointers SET message_id = " . $pointer . " WHERE user_id = " . $user_id .
				" AND sub_id = " . $sub_id;
	return @mysql_query($sql_set_ptr);
}

function _getNumMsgsInSub($sub_id) {
	$sql_msgs_in_sub = "SELECT COUNT(id) FROM messages WHERE sub_id = " . $sub_id;
	$sth_msgs_in_sub = @mysql_query($sql_msgs_in_sub);
	if ($sth_msgs_in_sub) {
		$row_msgs_in_sub = @mysql_fetch_assoc($sth_msgs_in_sub);
		return $row_msgs_in_sub['COUNT(id)'];
	}
	return 0;
}

function _displayMessage($message, $anonymous = null) {
	$message['message'] = ereg_replace("(\r\n|\n|\r)", "<br>", $message['message']);
?> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="bgTable">
			<table width="100%" cellpadding="4" cellspacing="1">
				<tr class="msgTitle"> 
					<td>From <strong> 
						<?php
	if ($anonymous == 'Y') {
?>
						Anonymous 
						<?php
	} else if (isset($message['email']) and $message['email'] != '') {
?>
						<a href="<?= $message['email'] ?>">
						<?= $message['alias'] ?></a>  #<?= $message['user_id'] ?>
						
						<?php
	} else {
?>
						<?= $message['alias'] ?> #<?= $message['user_id'] ?>
						<?php
	}	
?>
						</strong> on 
						<?= date("F j, Y, g:i a", $message['UNIX_TIMESTAMP(m.date)']) ?>
						:</td>
				</tr>
				<tr class="msgText"> 
					<td>
						<?= $message['message'] ?>
<?php
						if (isset($message['tagline'])) {
?>
						<br /><br /><span class="tagline">-- <br /><?= $message['tagline'] ?>
<?php } ?>
					</td>
				</tr>
			</table></td>
	</tr>
</table>
<?php
}

function _loopMsgs($sth_msgs, $pointer = null, $anonymous = null) {
	if (!$pointer) $pointer = 0;
	while ($row_msgs = @mysql_fetch_assoc($sth_msgs)) {
		_displayMessage($row_msgs, $anonymous);
		echo "<tr><td>&nbsp;</td></tr>";
		$pointer = $row_msgs['id'];
	}	
	return $pointer;
}

function _getNewMessages($sub_id, $pointer = null) {
	$max = 15;
	if (!$pointer) $pointer = 0;
	$sql_get_new_msgs = "SELECT m.id, m.message, t.tagline, UNIX_TIMESTAMP(m.date), u.alias, u.id as user_id, u.email FROM messages m,
			users u LEFT JOIN taglines t ON t.id = m.tag_id WHERE m.sub_id = " . $sub_id . " AND m.id >= " . $pointer . " AND u.id = m.user_id ORDER BY id LIMIT 15";
	return @mysql_query($sql_get_new_msgs);
}

function _getMessages($sub_id, $descending = null) {
	$sql_get_msgs = "SELECT m.id, m.message, t.tagline, UNIX_TIMESTAMP(m.date), u.alias, u.id as user_id, u.email FROM messages m, users u LEFT JOIN taglines t ON t.id = m.tag_id WHERE u.id = m.user_id AND m.sub_id = " . $_SESSION['sub'] . " ORDER BY m.id " ;
	if ($descending) 
		$sql_get_msgs .= 'DESC';
	return @mysql_query($sql_get_msgs);
}

function _getPointer($sub_id, $user_id) {
	$sql_get_pointers = "SELECT message_id FROM pointers WHERE user_id = " . $user_id . 
			" AND sub_id = " . $sub_id;
	$sth_get_pointers = @mysql_query($sql_get_pointers);
	$row_get_pointers = @mysql_fetch_assoc($sth_get_pointers);
	return $row_get_pointers['message_id'];
}

function _getNextSub() {
	$sql_get_next = "SELECT id FROM subs WHERE id > " . $_SESSION['sub'] .  " ORDER BY id ASC LIMIT 1";
	if ($sth_get_next = @mysql_query($sql_get_next) and @mysql_num_rows($sth_get_next) > 0) {
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
	$req['sub'] = _getNextSub();
	$_SESSION['sub'] = $req['sub'];
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

<body class="main">
<?php 

displayErrors();

if (isset($req['login'])) {

	if (isset($req['new']))
		echo "<p>{$_SESSION['alias']}, you are a n00b.</p>";
	else
		echo "<p>Hello again, <strong>{$_SESSION['alias']}</strong>.</p>";
		
	if (getUserPrefs($_SESSION['id'], 'DISP_LASTUSERS')) 
		echo getLastUsers();

	if (getUserPrefs($_SESSION['id'], 'DISP_AUTOMESS'))
		echo getAutomessage();	

	if (isset($req['login'])) 
		echo "<p><strong>Beginning Newscan:</strong></p>";
}
?>
<p class="subName"><?= $sub ?></p>
<table class="msgTable">
<?php

if (isset($req['sub']) or isset($_SESSION['sub'])) {
	$pointer = _getPointer($_SESSION['sub'], $_SESSION['id']);
	if (isset($req['newscan'])) {
		$sth_msgs = _getNewMessages($_SESSION['sub'], $pointer);
		$new_pointer = _loopMsgs($sth_msgs, $pointer, $anonymous);
	} elseif (isset($req['order']) and $req['order'] == 'desc') {
		$sth_msgs = _getMessages($_SESSION['sub'], true);
		$new_pointer = _loopMsgs($sth_msgs, null, $anonymous);
	} else {
		$sth_msgs = _getMessages($_SESSION['sub']);
		$new_pointer = _loopMsgs($sth_msgs, null, $anonymous);
	}
	if ($new_pointer > $pointer)
		_setPointer($_SESSION['sub'], $_SESSION['id'], $new_pointer);
}

?>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="bgTable">
			<table width="100%" border="0" cellpadding="4" cellspacing="1">
				<tr> 
					<td colspan="4" class="navbarTable"><strong>
						<?= $sub ?></strong> (<?= _getNumMsgsInSub($_SESSION['sub']) ?> messages)</td>
				</tr>
				<tr> 
					<td nowrap="nowrap" class="navbarTable"><a href="post.php?sub=<?= $_SESSION['sub'] ?>"><strong>Post 
						a Message</strong></a></td>
					<td nowrap="nowrap" class="navbarTable"><a href="main.php?order=asc">Read Forwards</a></td>
					<td nowrap="nowrap" class="navbarTable"> <a href="main.php?order=desc">Read Backwards</a></td>
					<td width="100%" class="navbarTable"><a href="post.php?sub=<?= $_SESSION['sub'] ?>"></a> 
						<a href="main.php?newscan=true&sub=<?= _getNextSub() ?>"><strong>Newscan 
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
