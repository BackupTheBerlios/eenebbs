<?php 

session_start();
require 'lib/config.php';
require 'lib/utils.php';
authenticate();

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; 
$sysops = array();
$sql_get_sysops = "SELECT alias, email FROM users WHERE sl = " . SYSOP_SL;
$sth_get_sysops = @mysql_query($sql_get_sysops);
while ($row_get_sysops = @mysql_fetch_assoc($sth_get_sysops)) {
	$sysops[] = array('alias' => $row_get_sysops['alias'], 'email' => $row_get_sysops['email']);
}

$sql_get_online_since = "SELECT UNIX_TIMESTAMP(MIN(first_login)) FROM stats";
$sth_get_online_since = @mysql_query($sql_get_online_since);
$row_get_online_since = @mysql_fetch_row($sth_get_online_since);
$online_since_timestamp = $row_get_online_since[0];
$online_since = date("F j, Y", $row_get_online_since[0]);

$sql_get_total_users = "SELECT COUNT(id) FROM users";
$sth_get_total_users = @mysql_query($sql_get_total_users);
$row_get_total_users = @mysql_fetch_row($sth_get_total_users);
$total_users = $row_get_total_users[0];

$sql_get_total_logins = "SELECT COUNT(id) FROM log WHERE event_id = 3";
$sth_get_total_logins = @mysql_query($sql_get_total_logins);
$row_get_total_logins = @mysql_fetch_row($sth_get_total_logins);
$total_logins = $row_get_total_logins[0];

$sql_get_total_msgs = "SELECT COUNT(id) FROM messages";
$sth_get_total_msgs = @mysql_query($sql_get_total_msgs);
$row_get_total_msgs = @mysql_fetch_row($sth_get_total_msgs);
$total_msgs = $row_get_total_msgs[0];

$sql_get_total_subs = "SELECT COUNT(id) FROM subs";
$sth_get_total_subs = @mysql_query($sql_get_total_subs);
$row_get_total_subs = @mysql_fetch_row($sth_get_total_subs);
$total_subs = $row_get_total_subs[0];

$sql_get_total_topics = "SELECT COUNT(id) FROM voting_topics";
$sth_get_total_topics = @mysql_query($sql_get_total_topics);
$row_get_total_topics = @mysql_fetch_row($sth_get_total_topics);
$total_topics = $row_get_total_topics[0];

$sql_get_total_mottos = "SELECT COUNT(id) FROM mottos";
$sth_get_total_mottos = @mysql_query($sql_get_total_mottos);
$row_get_total_mottos = @mysql_fetch_row($sth_get_total_mottos);
$total_mottos = $row_get_total_mottos[0];

$now = time();
$now_and_then = $now - $online_since_timestamp;
$days_online = round($now_and_then / 3600 / 24, 2);

$avg_posts_day = round($total_msgs / $days_online, 2);
$avg_logins_day = round($total_logins / $days_online, 2);
$avg_signups_day = round($total_users / $days_online, 2);

$sql_most_efficient = "SELECT (s.posts / s.logins) AS pcratio, u.alias FROM stats s, 
		users u where u.id = s.user_id AND u.sl <> 255 ORDER BY pcratio DESC LIMIT 1";
$sth_most_efficient = @mysql_query($sql_most_efficient);
$row_most_efficient = @mysql_fetch_assoc($sth_most_efficient);
$most_efficient = $row_most_efficient['alias'];

$sql_lurker = "SELECT sum( p.message_id )  / s.posts AS readratio, u.alias
FROM pointers p, users u, stats s
WHERE p.user_id = u.id AND p.user_id = s.user_id AND s.posts > 0 AND u.sl <> 255
GROUP  BY p.user_id
ORDER  BY readratio DESC 
LIMIT 1 ";
$sth_lurker = @mysql_query($sql_lurker);
$row_lurker = @mysql_fetch_assoc($sth_lurker);
$lurker = $row_lurker['alias'];

$sql_active = "SELECT ( s.posts * .25 ) + ( s.automessages * 2  )  + s.mottos + ( s.subs * 1.5  ) 
		AS active, u.alias FROM stats s, users u WHERE s.user_id = u.id AND u.sl <> 255 ORDER BY active DESC LIMIT 1";
$sth_active = @mysql_query($sql_active);
$row_active = @mysql_fetch_assoc($sth_active);
$active = $row_active['alias'];

$sql_forgetful = "SELECT count(  *  )  AS badpws, u.alias FROM log l, users u WHERE l.event_id = 14 
		AND l.user_id = u.id AND u.sl <> 255 GROUP  BY ( l.user_id ) ORDER  BY badpws DESC LIMIT 1";
$sth_forgetful = @mysql_query($sql_forgetful);
$row_forgetful = @mysql_fetch_assoc($sth_forgetful);
$forgetful = $row_forgetful['alias'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= BBSNAME ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body class="main">
<p><a href="stats.php">back to stats</a></p>
<table border="0" cellspacing="8" cellpadding="0">
	<tr>
		<td class="bgTable"> 
			<table width="100%" border="0" cellspacing="1" cellpadding="4">
				<tr> 
					<td valign="top" nowrap="nowrap" class="navbarTable">System Name:</td>
					<td class="navbarTable"><strong> 
						<?= BBSNAME ?>
						</strong></td>
				</tr>
				<tr> 
					<td valign="top" nowrap="nowrap" class="navbarTable">Sysops:</td>
					<td class="navbarTable"><strong> 
						<?php 
						foreach ($sysops as $sysop) {
							if ($sysop['email'] != '') 
								echo "<a href=\"mailto:" . $sysop['email'] . "\">" . $sysop['alias'] . "</a><br />";
							else
								echo $sysop['alias'] . '<br />';
						}
					?>
						</strong></td>
				</tr>
				<tr> 
					<td valign="top" nowrap="nowrap" class="navbarTable">Online Since:</td>
					<td class="navbarTable"> 
						<?= $online_since ?>
					</td>
				</tr>
				<tr> 
					<td valign="top" nowrap="nowrap" class="navbarTable">Total Users:</td>
					<td class="navbarTable">
						<?= $total_users ?>
					</td>
				</tr>
				<tr> 
					<td valign="top" nowrap="nowrap" class="navbarTable">Total Logins:</td>
					<td class="navbarTable">
						<?= $total_logins ?>
					</td>
				</tr>
				<tr> 
					<td valign="top" nowrap="nowrap" class="navbarTable">Total Messages:</td>
					<td class="navbarTable">
						<?= $total_msgs ?>
					</td>
				</tr>
				<tr> 
					<td valign="top" nowrap="nowrap" class="navbarTable">Total Subs:</td>
					<td class="navbarTable">
						<?= $total_subs ?>
					</td>
				</tr>
				<tr> 
					<td valign="top" nowrap="nowrap" class="navbarTable">Total Voting Questions:</td>
					<td class="navbarTable">
						<?= $total_topics ?>
					</td>
				</tr>
				<tr> 
					<td valign="top" nowrap="nowrap" class="navbarTable">Total Mottos: </td>
					<td class="navbarTable">
						<?= $total_mottos ?>
					</td>
				</tr>
				<tr> 
					<td valign="top" nowrap="nowrap" class="navbarTable">Avg. Posts/Day:</td>
					<td class="navbarTable">
						<?= $avg_posts_day ?>
					</td>
				</tr>
				<tr> 
					<td valign="top" nowrap="nowrap" class="navbarTable">Avg. Logins/Day:</td>
					<td class="navbarTable">
						<?= $avg_logins_day ?>
					</td>
				</tr>
				<tr>
					<td valign="top" nowrap="nowrap" class="navbarTable">Avg. Signups/Day:</td>
					<td class="navbarTable"><?= $avg_signups_day ?></td>
				</tr>
			</table>
		</td>
		<td valign="top" align="center"> 
			<table cellpadding="0" cellspacing="0" border="0"><tr><td class="bgTable">
				<table cellpadding="4" cellspacing="1" border="0">
							<tr> 
								<td nowrap="NOWRAP" class="navbar"><div align="center"><strong>Most 
										Active User</strong></div></td>
							</tr>
							<tr> 
								<td nowrap="nowrap" class="msgText"> 
									
									<div align="center"><?= $active ?></div></td>
							</tr>
						</table>
			</td></tr></table>
			<br />
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="bgTable"> <table cellpadding="4" cellspacing="1" border="0">
							<tr> 
								<td nowrap="nowrap" class="navbar"><div align="center"><strong>Most 
										Efficient User</strong></div></td>
							</tr>
							<tr> 
								<td nowrap="nowrap" class="msgText"> <div align="center">
										<?= $most_efficient ?>
									</div></td>
							</tr>
						</table></td>
				</tr>
			</table>
			<br />
			<table cellpadding="0" cellspacing="0" border="0"><tr><td class="bgTable">
				<table cellpadding="4" cellspacing="1" border="0">
							<tr> 
								<td nowrap="nowrap" class="navbar"><div align="center"><strong>Creepiest 
										Lurker</strong></div></td>
							</tr>
							<tr> 
								<td nowrap="nowrap" class="msgText"> 
									
									<div align="center"><?= $lurker ?></div></td>
							</tr>
						</table>
			</td></tr></table><br />
			<table cellpadding="0" cellspacing="0" border="0"><tr><td class="bgTable">
				<table cellpadding="4" cellspacing="1" border="0">
							<tr> 
								<td nowrap="nowrap" class="navbar"><div align="center"><strong>Most 
										Often<br />
										Forgetful User</strong></div></td>
							</tr>
							<tr> 
								<td nowrap="nowrap" class="msgText"> 
									
									<div align="center"><?= $forgetful ?></div></td>
							</tr>
						</table>
			</td></tr></table><br />			
		</td>
	</tr>
</table>
</body>
</html>
