<?php 

require_once 'lib/config.php';
require_once 'lib/utils.php';

session_start();
authenticate();
authenticateSysop();

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= BBSNAME ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body class="main">
<p><a href="sysop.php">back to sysop</a></p>
<p>ok here is a log. this should include querying options on a startdate/enddate 
	basis, query by user. we may want to make a notification about potential haxoring 
	as this information is recorded.. since we have a record of bad passwords.</p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="bgTable"><table cellpadding="4" cellspacing="1" width="100%">
				<tr class="msgTitle"> 
					<td>Date</td>
					<td>Event ID</td>
					<td>Type</td>
					<td>Description</td>
					<td>User</td>
					<td>Note</td>
				</tr>
				<?php

$sql_get_log = "SELECT l.date, l.event_id, e.short_descr, e.descr, u.alias, l.note FROM log l,
		event_ids e, users u WHERE u.id = l.user_id AND e.id = l.event_id ORDER BY l.date DESC";
$sth_get_log = @mysql_query($sql_get_log);	
while ($row = mysql_fetch_assoc($sth_get_log)) {
?>
				<tr class="msgText"> 
					<td> 
						<?= $row['date'] ?>
					</td>
					<td> 
						<?= $row['event_id'] ?>
					</td>
					<td>
						<?= $row['short_descr'] ?>
					</td>
					<td> 
						<?= $row['descr'] ?>
					</td>
					<td> 
						<?= $row['alias'] ?>
					</td>
					<td> 
						<?= $row['note'] ?>
					</td>
				</tr>
				<?php
}
?>
			</table></td>
	</tr>
</table>
</body>
</html>
