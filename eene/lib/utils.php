<?php

require_once 'config.php';

function clean($input, $maxlength) {
	$input = substr($input, 0, $maxlength);
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

@mysql_pconnect('localhost', DB_USERNAME, DB_PASSWORD) or die (@mysql_error());
@mysql_select_db(DB_NAME) or die (@mysql_error());

function getUserID($my_alias) {
	$sql_id = "SELECT id FROM users WHERE alias = '" . $my_alias . "'";
	$sth_id = @mysql_query($sql_id);
	$row = @mysql_fetch_assoc($sth_id);
	return $row['id'];
}

# increments stat.  $stat corresponds to field in 'stats' table
function incrementStat($stat_id, $stat) {
	if ($stat == 'logins') { # update last_login if this is a login
		$sql_last_login = "UPDATE stats SET last_login = NOW() WHERE user_id = " . $stat_id;
		@mysql_query($sql_last_login);
	}
	$sql_put_stat = "UPDATE stats SET " . $stat . " = (" . $stat . " + 1) WHERE user_id = " . $stat_id;
	return @mysql_query($sql_put_stat);
}

# 'type' corresponds to short_descr in 'event_ids' table
function myLog($type, $log_id = null, $note = null) {
	$sql_put_log = "INSERT INTO log (user_id, event_id, date, note) SELECT " . $log_id . " AS user_id, id 
			AS event_id, NOW() as date, '" . $note . "' AS note FROM event_ids WHERE short_descr = '" . $type . "'";
	return @mysql_query($sql_put_log);
}

function hasVoted($user_id, $topic_id) {
	$sql_check_vote = "SELECT v.id FROM votes v WHERE v.topic_id = " . $topic_id . " AND v.user_id
			 = " . $user_id;
	$sth_check_vote = @mysql_query($sql_check_vote);
  return (@mysql_num_rows($sth_check_vote) > 0); 
}

function getAutomessage() {	
	$sql_get_automessage = "SELECT a.automessage, u.alias, u.id, u.email, UNIX_TIMESTAMP(a.date) FROM automessages a, users u 
		WHERE u.id = a.user_id ORDER BY a.id DESC LIMIT 1";
	if ($sth_get_automessage = @mysql_query($sql_get_automessage)) {
		$row = @mysql_fetch_assoc($sth_get_automessage);
		$date = date("F j, Y, g:i a", $row['UNIX_TIMESTAMP(a.date)']);
		$automess = <<<EOT
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="bgTable">
			<table width="100%" cellpadding="4" cellspacing="1">
				<tr> 
					<td class="msgTitle">Automessage by #{$row['id']} <strong>
EOT;
		$automess .= ($row['email'] != '') ? 
				"<a href=\"mailto:{$row['email']}\">{$row['alias']}</a>" : 
$row['alias'];
		$automess .= <<<EOT
</strong> on {$date}</td>
				</tr>
				<tr> 
					<td class="msgText">
						{$row['automessage']}
					</td>
				</tr>
			</table></td>
	</tr>
</table>
EOT;
		return $automess;
	} else {
		return false;
	}
}

function getUserPrefs($pref_id, $pref = null) {
	if (!$pref) {
		$user_prefs = array();
		$sql_get_user_prefs = "SELECT * FROM user_preferences WHERE user_id = " . $pref_id;
		$sth_get_user_prefs = @mysql_query($sql_get_user_prefs);
		while ($row_user_prefs = @mysql_fetch_assoc($sth_get_user_prefs)) {
			$user_prefs[$row_user_prefs['pref_id']] = $row_user_prefs['value'];
		}
	} else {
		$user_prefs = '';
		$sql_get_user_pref = "SELECT up.* FROM user_preferences up, preferences p WHERE up.user_id = " . $pref_id . 
				" AND p.id = up.pref_id AND p.short_descr = '" . $pref . "'";
		$sth_get_user_pref = @mysql_query($sql_get_user_pref);
		$row_user_pref = @mysql_fetch_assoc($sth_get_user_pref);
		$user_prefs = $row_user_pref['value'];
	}
	return $user_prefs;
}

function getLastUsers() {
	$string = <<<EOT
<p><strong>Last 5 users:</strong></p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="bgTable">
			<table cellpadding="4" cellspacing="1" width="100%">
				<tr> 
					<td class="msgTitle" nowrap="nowrap">User</td>
					<td class="msgTitle" width="100%">Time</td>
				</tr>
EOT;
	$sql_last_logins = "SELECT u.id, u.alias, u.email, UNIX_TIMESTAMP(l.date) FROM log l, 
		users u WHERE l.event_id = 3 AND u.id = l.user_id ORDER BY l.date DESC LIMIT 5";
	$sth_last_logins = @mysql_query($sql_last_logins);
	while ($row_last_logins = @mysql_fetch_assoc($sth_last_logins)) {
		$time = date("F j, Y, g:i a", 
				$row_last_logins['UNIX_TIMESTAMP(l.date)']); 
		$string .= <<<EOT
				<tr>
					<td class="msgTable" nowrap="nowrap">{$row_last_logins['alias']} #{$row_last_logins['id']} </td>
					<td class="msgTable" width="100%">{$time}</td>
				</tr>
EOT;
	}
	$string .= <<<EOT
			</table>
		</td>
	</tr>
</table><br />
EOT;
	return $string;
}

function displayErrors(){
	$error = '';
	$success = '';
	if (isset($_SESSION['error'])) {
		$error = $_SESSION['error'];
	} else if (isset($_GET['error'])) {
		$error = $_GET['error'];
	}
	if (isset($_SESSION['success'])) {
		$success = $_SESSION['success'];
	} else if (isset($_GET['success'])) {
		$success = $_GET['success'];
	}
	if ($success != '') {
		$_SESSION['success'] = null;
		unset($_SESSION['success']);
		echo "<p class=\"success\">" . $success . "</p>";
	}
	if ($error != '') {
		$_SESSION['error'] = null;
		unset($_SESSION['error']);
		echo "<p class=\"error\">" . $error . "</p>";
	}
}
?>
