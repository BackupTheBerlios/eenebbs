<?php

require_once 'config.php';

function cleanAllowImg($input, $maxlength) {
	$input = substr($input, 0, $maxlength);
	$input = escapeshellcmd($input);
	$input = _safeHTML($input);
	$input = preg_replace("/\|/", "", $input);
	return $input;
}

function clean($input, $maxlength) {
	$input = substr($input, 0, $maxlength);
	$input = escapeshellcmd($input);
	$input = strip_tags($input);
	$input = preg_replace("/\|/", "", $input);
	return $input;
}

# bounces user if no session vars set
function authenticate() {
	if (!isset($_SESSION['alias']) and !isset($_SESSION['logged_in']) and !isset($_SESSION['sl'])) {
		header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "?authenticated=false");
		exit;
	}
}

function authenticateSysop() {
	if ($_SESSION['sl'] != SYSOP_SL) {
		header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "main.php?nopermission=true");
		exit;
	}
}

# probably only want to allow images in the messages themselves
function _safeHTML($text) { 
	$text = stripslashes($text);
	$text = strip_tags($text, '<b><i><u><a><img>');
	$text = preg_replace ("/\"javascript:.*\"/i", "", $text);
	return $text;
}

function debug($var) {
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}


#### BEGIN DATABASE FUNCTIONS ####

@mysql_pconnect('localhost', DB_USERNAME, DB_PASSWORD) or die (mysql_error());
@mysql_select_db(DB_NAME) or die (mysql_error());

function getUserID($alias) {
	$sql_id = "SELECT id FROM users WHERE alias = '" . $alias . "'";
	$sth_id = @mysql_query($sql_id);
	$row = mysql_fetch_assoc($sth_id);
	return $row['id'];
}

# increments stat.  $stat corresponds to field in 'stats' table
function incrementStat($id, $stat) {
	if ($stat == 'logins') { # update last_login if this is a login
		$sql_last_login = "UPDATE stats SET last_login = NOW() WHERE user_id = " . $id;
		mysql_query($sql_last_login);
	}
	$sql_put_stat = "UPDATE stats SET " . $stat . " = (" . $stat . " + 1) WHERE user_id = " . $id;
	return mysql_query($sql_put_stat);
}

# 'type' corresponds to short_descr in 'event_ids' table
function myLog($type, $id = null, $note = null) {
	$sql_put_log = "INSERT INTO log (user_id, event_id, date, note) SELECT " . $id . " AS user_id, id 
			AS event_id, NOW() as date, '" . $note . "' AS note FROM event_ids WHERE short_descr = '" . $type . "'";
	return @mysql_query($sql_put_log);
}

function hasVoted($user_id, $topic_id) {
	$sql_check_vote = "SELECT v.id FROM votes v WHERE v.topic_id = " . $topic_id . " AND v.user_id
			 = " . $user_id;
	$sth_check_vote = @mysql_query($sql_check_vote);
  return (@mysql_num_rows($sth_check_vote) > 0); 
}

# text should look identical to getMessage function if there ever is such a monster
function getAutomessage() {	
	$sql_get_automessage = "SELECT a.automessage, u.alias, UNIX_TIMESTAMP(a.date) FROM automessages a, users u 
		WHERE u.id = a.user_id ORDER BY a.id DESC LIMIT 1";
	if ($sth_get_automessage = @mysql_query($sql_get_automessage)) {
		$row = mysql_fetch_assoc($sth_get_automessage);
		$date = date("F j, Y, g:i a", $row['UNIX_TIMESTAMP(a.date)']);
		return <<<EOT
	<p>Automessage by <strong>{$row['alias']}</strong> on {$date}</p>
	<p>{$row['automessage']}</p>
EOT;
	} else {
		return false;
	}
}

function getUserPrefs($id, $pref = null) {
	if (!$pref) {
		$user_prefs = array();
		$sql_get_user_prefs = "SELECT * FROM user_preferences WHERE user_id = " . $id;
		$sth_get_user_prefs = mysql_query($sql_get_user_prefs);
		while ($row_user_prefs = mysql_fetch_assoc($sth_get_user_prefs)) {
			$user_prefs[$row_user_prefs['pref_id']] = $row_user_prefs['value'];
		}
	} else {
		$user_prefs = '';
		$sql_get_user_pref = "SELECT up.* FROM user_preferences up, preferences p WHERE up.user_id = " . $id . 
				" AND p.id = up.pref_id AND p.short_descr = '" . $pref . "'";
		$sth_get_user_pref = mysql_query($sql_get_user_pref);
		$row_user_pref = mysql_fetch_assoc($sth_get_user_pref);
		$user_prefs = $row_user_pref['value'];
	}
	return $user_prefs;
}

function getSubs() {
	$sql_get_subs = "SELECT * FROM subs ORDER BY id";
	return @mysql_query($sql_get_subs);
}

function getPointer($sub_id, $user_id) {
	$sql_get_pointers = "SELECT message_id FROM pointers WHERE user_id = " . $user_id . 
			" AND sub_id = " . $sub_id;
	$sth_get_pointers = @mysql_query($sql_get_pointers);
	$row_get_pointers = @mysql_fetch_assoc($sth_get_pointers);
	return $row_get_pointers['message_id'];
}

function getNewMessages($sub_id, $pointer = null) {
	$max = 15;
	if (!$pointer) $pointer = 0;
	$sql_get_new_msgs = "SELECT m.id, m.message, UNIX_TIMESTAMP(m.date), u.alias, u.email FROM messages m,
			users u	WHERE m.sub_id = " . $sub_id . " AND m.id >= " . $pointer . " AND u.id = m.user_id ORDER BY id LIMIT 15";
	return @mysql_query($sql_get_new_msgs);
}

function getMessages($sub_id, $descending = null) {
	$sql_get_msgs = "SELECT m.id, m.message, UNIX_TIMESTAMP(m.date), u.alias, u.email FROM messages m, 
			users u WHERE u.id = m.user_id AND m.sub_id = " . $sub_id . " ORDER BY m.id ";
	if ($descending) 
		$sql_get_msgs .= 'DESC';
	return @mysql_query($sql_get_msgs);
}

function setPointer($sub_id, $user_id, $pointer) {
	if (getPointer($sub_id, $user_id) > 0) {
		$sql_set_ptr = "UPDATE pointers SET message_id = " . $pointer . " WHERE user_id = " . $user_id .
				" AND sub_id = " . $sub_id;
	} else {
		$sql_set_ptr = "INSERT INTO pointers (user_id, sub_id, message_id) VALUES (" . $user_id . ", " . 
				$sub_id . ", " . $pointer . ")";
	}
	return @mysql_query($sql_set_ptr);
}

function displayMessage($message, $anonymous = null) {
?>
<table class="msgTable" width="100%" cellpadding="4">
<tr>
<td class="msgTitle">From <strong>
<?php
	if ($anonymous == 'Y') {
?>
	Anonymous
<?php
	} else if (isset($message['email'])) {
?>
	<a href="<?= $message['email'] ?>"><?= $message['alias'] ?></a>
<?php
	} else {
?>
	<?= $message['alias'] ?>
<?php
	}	
?></strong> on <?= date("F j, Y, g:i a", $message['UNIX_TIMESTAMP(m.date)']) ?>:<br />&nbsp;</td>
</tr>
<tr>
<td class="msgText"><?= $message['message'] ?></td>
</tr>
</table>
<?php
}
?>