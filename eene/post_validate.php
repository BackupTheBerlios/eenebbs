<?php

require_once 'lib/utils.php';
require_once 'lib/config.php';

session_start();
authenticate();

# this is kind of dumb
define ( 'RANDOMLY', 5 );
define ( 'LOOP', 6 );

$message = trim(clean($_POST['message'], MAXMSGLENGTH));

$_SESSION['sub'] = $_POST['postsub'];

if ($message == '' or !isset($message)) {
	$_SESSION['error'] = "Post failed; blank message detected.";
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		"/main.php");
	exit;
}

switch (getUserPrefs($_SESSION['id'], 'TAGLINES')) {
	case RANDOMLY:
		$sql_get_tagline = "SELECT id FROM taglines WHERE user_id = " . $_SESSION['id'] . " ORDER BY RAND() LIMIT 1";
		$sth_get_tagline = @mysql_query($sql_get_tagline);
		if ($sth_get_tagline and @mysql_num_rows($sth_get_tagline) > 0) {
			$row_get_tagline = @mysql_fetch_assoc($sth_get_tagline);
			$tagline = $row_get_tagline['id'];
		} 
		break;
	case LOOP:
		$sql_get_tagline = "SELECT t.id FROM taglines t, users u WHERE u.last_tagline = t.id AND u.id = " . $_SESSION['id'];
		$sth_get_tagline = @mysql_query($sql_get_tagline);
		if ($sth_get_tagline and @mysql_num_rows($sth_get_tagline) > 0) {
			$row_get_tagline = @mysql_fetch_assoc($sth_get_tagline);
			$tagline = $row_get_tagline['id'];
		} else {
			$sql_get_tagline = "SELECT t.id FROM taglines t WHERE user_id = " . $_SESSION['id'];
			if ($sth_get_tagline and @mysql_num_rows($sth_get_tagline) > 0) {
				$row_get_tagline = @mysql_fetch_assoc($sth_get_tagline);
				$tagline = $row_get_tagline['id'];
			}
		}
 		break; 
}
if ($tagline) 
	$sql_post = "INSERT INTO messages (sub_id, user_id, message, date, tag_id) VALUES (" . $_SESSION['sub'] .
			", " . $_SESSION['id'] . ", '" . $message . "', NOW(), " . $tagline . " )";
else
	$sql_post = "INSERT INTO messages (sub_id, user_id, message, date) VALUES (" . $_SESSION['sub'] .
			", " . $_SESSION['id'] . ", '" . $message . "', NOW())";
			
if (@mysql_query($sql_post)) {
	incrementStat($_SESSION['id'], 'posts');
	myLog('POST', $_SESSION['id'], $_SESSION['sub']);
	$_SESSION['success'] = "Message posted!";
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		"/main.php?newscan=true&current=true&nojump=true&sub=" . $_SESSION['sub']);
	exit;
} else {
	$_SESSION['error'] = "Post failed.";
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		"/main.php?newscan=true&current=true&nojump=true&sub=" . $_SESSION['sub']);
	exit;
}
?>