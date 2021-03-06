<?php 

require_once 'lib/config.php';
require_once 'lib/utils.php';

session_start();
authenticate();

define('MSGS_PER_PAGE', 20);

function _nextSubWithMsgs($user_id) {
	$sql_are_new = "SELECT p.sub_id, count(m.id) FROM pointers p, messages m WHERE p.user_id = " .$user_id . " AND p.sub_id = m.sub_id AND p.message_id < m.id GROUP BY p.sub_id";
        $sth_are_new = @mysql_query($sql_are_new);
        while ($row_are_new = @mysql_fetch_array($sth_are_new)) {
		return array(true, $row_are_new[0]); 
        }
	return array(false, 1);
}
	
function _areMoreMsgs($sub_id, $pointer, $order) {
	if ($order == 'desc') {	
		$sql_are_more = "SELECT COUNT(id) FROM messages WHERE sub_id = " . $sub_id . " AND id < " . $pointer;
		$sth_are_more = @mysql_query($sql_are_more);
		$row_are_more = @mysql_fetch_assoc($sth_are_more);
		if ($row_are_more['COUNT(id)'] > 0)
			return true;
	} else {
		$sql_are_more = "SELECT COUNT(id) FROM messages WHERE sub_id = " . $sub_id . " AND id > " . $pointer;
		$sth_are_more = @mysql_query($sql_are_more);
		$row_are_more = @mysql_fetch_assoc($sth_are_more);
		if ($row_are_more['COUNT(id)'] > 0)
			return true;
	}		
	return false;
}

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

function _loopMsgs($sth_msgs, $high_pointer = null, $anonymous = null) {
	if (!$high_pointer) $high_pointer = 0;
	$low_pointer = $high_pointer;
	while ($row_msgs = @mysql_fetch_assoc($sth_msgs)) {
		displayMessage($row_msgs, $anonymous);
		echo "<tr><td>&nbsp;</td></tr>";
		$high_pointer = ($row_msgs['id'] > $high_pointer) ? $row_msgs['id'] : $high_pointer;
		$low_pointer = $row_msgs['id'];
	}	
	return array($high_pointer, $low_pointer);
}

function _getNewMessages($sub_id, $pointer = null) {
	if (!$pointer) $pointer = 0;
	$sql_get_new_msgs = "SELECT m.id, m.message, t.tagline, UNIX_TIMESTAMP(m.date), u.alias, u.id as user_id, u.email FROM messages m,
			users u LEFT JOIN taglines t ON t.id = m.tag_id WHERE m.sub_id = " . $sub_id . " AND m.id >= " . $pointer . " AND u.id = m.user_id ORDER BY id LIMIT " . MSGS_PER_PAGE;
	return @mysql_query($sql_get_new_msgs);
}

function _getMessages($sub_id, $descending = null, $pointer = null) {
	$sql_get_msgs = "SELECT m.id, m.message, t.tagline, UNIX_TIMESTAMP(m.date), u.alias, u.id as user_id, u.email FROM messages m, users u LEFT JOIN taglines t ON t.id = m.tag_id WHERE u.id = m.user_id AND m.sub_id = " . $_SESSION['sub'];
	if ($pointer) {
		if ($descending)  
			$sql_get_msgs .= ' AND m.id <= ' . $pointer . ' ORDER BY m.id DESC ';
		else
			$sql_get_msgs .= ' AND m.id >= ' . $pointer . ' ORDER BY m.id ASC ';
	} else {
		if ($descending) 
			$sql_get_msgs .= ' ORDER BY m.id DESC ';
		else
			$sql_get_msgs .= ' ORDER BY m.id ASC ';
	}
	$sql_get_msgs .= 'LIMIT ' . MSGS_PER_PAGE;
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
	if ($sth_get_next = @mysql_query($sql_get_next) and @mysql_num_rows($sth_get_next) > 0)
		$row_get_next = @mysql_fetch_assoc($sth_get_next);
	else 
		$row_get_next['id'] = 1;
	return $row_get_next['id'];
}

function _getPrevSub() {
	$sql_get_prev = "SELECT id FROM subs WHERE id < " . $_SESSION['sub'] . " ORDER BY id DESC LIMIT 1";
	if ($sth_get_prev = @mysql_query($sql_get_prev) and mysql_num_rows($sth_get_prev) > 0) {
		$row_get_prev = @mysql_fetch_assoc($sth_get_prev);
	} else {
		$sql_get_prev = "SELECT id FROM subs ORDER BY id DESC LIMIT 1";
		$sth_get_prev = @mysql_query($sql_get_prev);
		$row_get_prev = @mysql_fetch_assoc($sth_get_prev);
	}
	return $row_get_prev['id'];
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
	list($more_msgs, $req['sub']) = _nextSubWithMsgs($_SESSION['id']); 
	$_SESSION['sub'] = $req['sub'];
} 

list($more_msgs, $next_sub_with_msgs) = _nextSubWithMsgs($_SESSION['id']);

if ($more_msgs and isset($req['newscan']) and !isset($req['nojump'])) {
	list($more_msgs, $_SESSION['sub']) = _nextSubWithMsgs($_SESSION['id']);
	$req['sub'] = $_SESSION['sub'];
}

$sql_sub = "SELECT name, anonymous FROM subs WHERE id = " . $_SESSION['sub'];
$sth_sub = @mysql_query($sql_sub);
$row_sub = @mysql_fetch_assoc($sth_sub);
$sub_name = $row_sub['name'];
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
		
	$sql_new_questions = "SELECT count( DISTINCT vt.id ) , count( DISTINCT v.id ) 
			FROM voting_topics vt, votes v WHERE user_id = " . $_SESSION['id'];
	$sth_new_questions = @mysql_query($sql_new_questions);
	$row_new_questions = @mysql_fetch_array($sth_new_questions);
	if ($row_new_questions[1] == 0 or $row_new_questions[0] > $row_new_questions[1]) {
		echo "<p><strong>There are new <a href=\"voting_booth.php\">voting topics</a>!</strong></p>";
	}

	if (getUserPrefs($_SESSION['id'], 'DISP_LASTUSERS')) 
		echo getLastUsers();

	if (getUserPrefs($_SESSION['id'], 'DISP_AUTOMESS'))
		echo getAutomessage();	

	if (isset($req['login'])) 
		echo "<p><strong>Beginning Newscan:</strong></p>";
}

$order = (isset($req['order'])) ? $req['order'] : 'asc';

?>
<p class="subName"><?= $sub_name ?> <span class="eene">
<?php
if (!isset($req['newscan'])) {
	if ($order and $order == 'desc') {
?>
		(reading backwards)
<?php
	} else {
?>
		(reading forwards)
<?php
	}
}
?>
</p>
<table class="msgTable">
<?php
		
$next_sub = _getNextSub();
$prev_sub = _getPrevSub();

$pointer = _getPointer($_SESSION['sub'], $_SESSION['id']);
$passed_pointer = (isset($req['pointer'])) ? $req['pointer'] : null;

if (isset($req['newscan'])) {
	$sth_msgs = _getNewMessages($_SESSION['sub'], $pointer);
	list($new_pointer, $low_pointer) = _loopMsgs($sth_msgs, $pointer, $anonymous);
} elseif ($order and $order == 'desc') {
	$sth_msgs = _getMessages($_SESSION['sub'], true, $passed_pointer);
	list($new_pointer, $low_pointer) = _loopMsgs($sth_msgs, $pointer, $anonymous);
} else {
	$sth_msgs = _getMessages($_SESSION['sub'], false, $passed_pointer);
	list($new_pointer, $low_pointer) = _loopMsgs($sth_msgs, $pointer, $anonymous);
}
if ($new_pointer > $pointer)
	_setPointer($_SESSION['sub'], $_SESSION['id'], $new_pointer);
if (!$low_pointer)
	$low_pointer = $new_pointer;

list($more_msgs, $next_sub_with_msgs) = _nextSubWithMsgs($_SESSION['id']);

?>
</table>
<br />
<?php
if (_areMoreMsgs($_SESSION['sub'], $low_pointer, $order)) {
	if (isset($req['newscan'])) {
?>
<a href="main.php?nojump=true&newscan=true&sub=<?= $_SESSION['sub'] ?>" >
<?php
	} else {
?>
<a href="main.php?nojump=true&order=<?= $order ?>&sub=<?= $_SESSION['sub'] ?>&pointer=<?= $low_pointer ?>" >
<?php
	}
?>
Read more messages in current sub...</a><br /><br />
<?php
}
if (!$more_msgs and isset($req['newscan']) 
		and $_SESSION['sub'] == 1) {
	echo "<p><strong>There are no more new messages.</strong></p>";
}
?>
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="bgTable">
			<table border="0" cellpadding="4" cellspacing="1">
				<tr> 
					<td colspan="6" class="navbarTable"><strong>
						<?= $sub_name ?></strong> (<?= _getNumMsgsInSub($_SESSION['sub']) ?> messages)</td>
				</tr>
				<tr> 
					<td nowrap="nowrap" class="navbarTable"><a href="post.php"><strong>Post 
						a Message</strong></a></td>
					<td nowrap="nowrap" class="navbarTable"><a href="main.php?order=asc">Read Forwards</a></td>
					<td nowrap="nowrap" class="navbarTable"><a href="main.php?order=desc">Read Backwards</a></td>
					<td nowrap="nowrap" class="navbarTable"><a href="main.php?sub=<?= $prev_sub ?>&order=desc">Previous Sub</a></td>
					<td nowrap="nowrap" class="navbarTable"><a href="main.php?sub=<?= $next_sub ?>&order=desc">Next Sub</a></td>
					<td nowrap="nowrap" class="navbarTable"><a href="main.php?newscan=true&sub=<?= $next_sub_with_msgs ?>" ><strong>Newscan Next Sub</strong></a>
					</td>
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
