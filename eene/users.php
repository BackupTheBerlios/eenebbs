<?php 

require_once 'lib/config.php';
require_once 'lib/utils.php';

session_start();
authenticate();

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<body>

<p>a user list</p>
<table border=1>
	<tr>
		<td>Alias</td>
		<td>Location</td>
		<td>Website</td>
		<td>Security Level</td>
		<td>Avatar</td>
		<td>User Since</td>
	</tr>
<?php

$sql_users = "SELECT u.alias, u.location, u.email, s.descr, u.site, u.avatar, 
		UNIX_TIMESTAMP(st.first_login) FROM stats st, users u, security_levels s WHERE 
		s.sl = u.sl AND st.user_id = u.id ORDER BY s.sl DESC, u.alias";
$users = @mysql_query($sql_users);

while ($row = mysql_fetch_assoc($users)) {
?>
	<tr>
		<td>
<?php
	if ($row['email'] != '') {
?>
		<a href="mailto:<?= $row['email'] ?>"><?= $row['alias'] ?></a>
<?php
	} else {
?>
		<?= $row['alias'] ?>
<?php
	}
?>		
		</td>
		<td><?= $row['location'] ?></td>
		<td><a href="<?= $row['site'] ?>"><?= $row['site'] ?></a></td>
		<td><?= $row['descr'] ?></td>
		<td><img src="<?= $row['avatar'] ?>" /></td>
		<td><?= date("F j, Y", $row['UNIX_TIMESTAMP(st.first_login)']) ?></td>
	</tr>
<?php } ?>
</table>
</body>
</html>
