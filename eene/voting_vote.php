<?php 

require_once 'lib/utils.php';
require_once 'lib/config.php';

session_start();
authenticate();

foreach ($_GET as $name => $value) 
	$req[$name] = trim(clean($value, 255));
foreach ($_POST as $name => $value) 
	$req[$name] = trim(clean($value, 255));


$sql_topic = "SELECT name FROM voting_topics WHERE id = " . $req['id'];
$sth_topic = @mysql_query($sql_topic);

$sql_options = "SELECT id, opt FROM voting_options WHERE topic_id = " . $req['id'] . " ORDER BY id";
$sth_options = @mysql_query($sql_options);


echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= BBSNAME ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body class="main">
<p><a href="voting_booth.php">back to voting 
	booth</a> </p>
<?php
if (!hasVoted($_SESSION['id'], $req['id'])) {
	$row_topic = mysql_fetch_assoc($sth_topic);
?>
	<form method="post" action="voting_tally.php" name="form1">
	<h1><?= $row_topic['name'] ?></h1>
<?php
	while($row_options = mysql_fetch_assoc($sth_options)) {
?>
	<p>
		<label>
		<input type="radio" name="option" value="<?= $row_options['opt'] ?>" />
		<?= $row_options['opt'] ?>
		</label>
		<br />
	</p>
<?php
	}
?>
	<input type="hidden" name="id" value="<?= $req['id'] ?>">
	<input name="submit" type="submit" id="submit" value="tally it" />
</form>
<?php
} else {

	$votes = array();
	$user_vote = '';
	$sql_tally_votes = "SELECT u.alias, vo.opt FROM votes v, voting_options vo, users u WHERE 
			v.topic_id = " . $req['id'] . " AND vo.id = v.option_id AND v.user_id = u.id";
	$sth_tally_votes = @mysql_query($sql_tally_votes);
	while ($row_tally_votes = @mysql_fetch_assoc($sth_tally_votes)) {
		if (!isset($votes[$row_tally_votes['opt']])) 
			$votes[$row_tally_votes['opt']] = 1;
		else 
			$votes[$row_tally_votes['opt']]++;
		if ($row_tally_votes['alias'] == $_SESSION['alias'])
			$user_vote = $row_tally_votes['opt'];
	}
	$total_votes = 0;
	foreach ($votes as $vote => $number) {
		$total_votes += $number;
	}
	$row_topic = mysql_fetch_assoc($sth_topic);
?>
	<h1><?= $row_topic['name'] ?></h1>
	<p>Your vote is in bold.</p>
<?php
	while ($row_options = mysql_fetch_assoc($sth_options)) {
		if (isset($votes[$row_options['opt']])) 
			$pct = floor(100 * ($votes[$row_options['opt']] / $total_votes) + .5);
		else
			$pct = 0;
		$votes_string = '';
		if (isset($votes[$row_options['opt']])) {
			if ($votes[$row_options['opt']] == 1) 
				$votes_string = '1 vote';
			else
				$votes_string = $votes[$row_options['opt']] . ' votes';
		} else {
			$votes_string = '0 votes';
		}
?>
	<p>
		<label>		
<?php
		if ($row_options['opt'] == $user_vote) {
?>
		<strong><?= $pct ?> % (<?= $votes_string ?>): <?= $row_options['opt'] ?></strong>
<?php
		} else {
?>
		<?= $pct ?> % (<?= $votes_string ?>): <?= $row_options['opt'] ?>
<?php
		}
?>
		</label>
		<br />
	</p>
<?php
	}
}
?>
</body>
</html>
