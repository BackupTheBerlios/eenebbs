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
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<body>
<p><a href="sysop.php">back to sysop</a></p>
<p>ok here is a log. this should include querying options on a startdate/enddate 
	basis, query by user. we may want to make a notification about potential haxoring 
	as this information is recorded.</p>

<table border=1>
	<tr> 
		<td><strong>Date</strong></td>
		<td><strong>Type</strong></td>
		<td><strong>Description</strong></td>
		<td><strong>User</strong></td>
		<td><strong>Note</strong></td>
	</tr>
	<?php

$sql_get_log = "SELECT l.date, l.event_id, e.descr, u.alias, l.note FROM log l,
		event_ids e, users u WHERE u.id = l.user_id AND e.id = l.event_id ORDER BY l.date DESC";
$sth_get_log = @mysql_query($sql_get_log);	
while ($row = mysql_fetch_assoc($sth_get_log)) {
?>
	<tr> 
		<td> 
			<?= $row['date'] ?>
		</td>
		<td> 
			<?= $row['event_id'] ?>
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
</table>
</body>
</html>
