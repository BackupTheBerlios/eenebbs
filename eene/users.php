<?php 

require_once 'lib/config.php';
require_once 'lib/utils.php';

session_start();
authenticate();

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= BBSNAME ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body class="main">

<p>a user list</p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="bgTable">
			<table cellpadding="4" cellspacing="1" width="100%">
				<tr> 
					<td class="msgTitle" nowrap="nowrap">User #</td>
					<td class="msgTitle">Alias</td>
					<td class="msgTitle">Location</td>
					<td class="msgTitle">Website</td>
					<td class="msgTitle">Security Level</td>
					<td class="msgTitle">User Since</td>
				</tr>
				<?php

$sql_users = "SELECT u.alias, u.id, u.location, u.email, s.descr, u.site,
		UNIX_TIMESTAMP(st.first_login) FROM stats st, users u, security_levels s WHERE 
		s.sl = u.sl AND st.user_id = u.id ORDER BY s.sl DESC, u.id";
$users = @mysql_query($sql_users);

while ($row = @mysql_fetch_assoc($users)) {
?>
				<tr> 
					<td class="msgTable"> 
						<?= $row['id'] ?>
					</td>
					<td class="msgTable" nowrap="nowrap">
						<?php
	if ($row['email'] != '') {
?>
						<a href="mailto:<?= $row['email'] ?>"> 
						<?= $row['alias'] ?>
						</a> 
						<?php
	} else {
?>
						<?= $row['alias'] ?>
						<?php
	}
?>
					</td>
					<td class="msgTable"> 
						<?= $row['location'] ?>
					</td>
					<td class="msgTable"><a href="http://<?= $row['site'] ?>"> 
						<?= $row['site'] ?>
						</a></td>
					<td class="msgTable" nowrap="nowrap"> 
						<?= $row['descr'] ?>
					</td>
					<td class="msgTable" nowrap="nowrap"> 
						<?= date("F j, Y", $row['UNIX_TIMESTAMP(st.first_login)']) ?>
					</td>
				</tr>
				<?php } ?>
			</table></td>
	</tr>
</table>
</body>
</html>
