<?php

require_once 'lib/utils.php';

session_start();
authenticate();

foreach ($_POST as $name => $value) 
	$req[$name] = trim(clean($value, 255));

if (!isset($req['id']) or !isset($req['option']) or hasVoted($_SESSION['id'], $req['id'])) {
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
			"/voting_vote.php?badvote=true" . "&id=" . $req['id']);
	exit;
}

$sql_tally = "INSERT INTO votes (user_id, topic_id, option_id) SELECT u.id AS user_id, 
		vt.id AS topic_id, vo.id AS option_id FROM users u, voting_topics vt, voting_options vo
		WHERE u.alias = '" . $_SESSION['alias'] . "' AND vt.id = " . $req['id'] . " AND vo.opt 
		= '" . $req['option'] . "'";

myLog('VOTE', $_SESSION['id'], $req['id']);

if (mysql_query($sql_tally)) {
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
			"/voting_vote.php?id=" . $req['id']);
	exit;
} else {
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
			"/voting_vote.php?badvote=true" . "&id=" . $req['id']);
	exit;
}
?>