<?php

require_once 'lib/utils.php';
require_once 'lib/config.php';

session_start();

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body class="main">
<p>here you can edit some user prefs and user info.</p>
<p>YOUR user INFO:</p>
<?php

$sql_get_user_info = "SELECT location, email, site FROM users WHERE id = " . $_SESSION['id'];
$sth_get_user_info = @mysql_query($sql_get_user_info);
$row_user_info = @mysql_fetch_assoc($sth_get_user_info);
?>
<form action="prefs_validate.php" method="post">
<table border="0">
	<tr>
		<td>Location (public)</td>
		<td><input name="location" type="text" id="location" value="<?= $row_user_info['location'] ?>" /></td>
	</tr>
	<tr>
		<td>Email (public)</td>
		<td><input name="email" type="text" id="email" value="<?= $row_user_info['email'] ?>" /></td>
	</tr>
	<tr>
		<td>Website (public)</td>
		<td>http://<input name="site" type="text" id="site" value="<?= $row_user_info['site'] ?>" /></td>
	</tr>
</table>
<p>Now some DEFAULTS:</p>
<table border="0">
<?php

$sql_get_prefs = "SELECT * FROM preferences";
$sth_get_prefs = mysql_query($sql_get_prefs);
$user_prefs = getUserPrefs($_SESSION['id']);
while ($row_prefs = mysql_fetch_assoc($sth_get_prefs)) {
?>
	<tr>
		<td><?= $row_prefs['descr']?></td>			<?php	
	switch ($row_prefs['type']) {
		case 'bit':
?>
			<td><input name="p<?= $row_prefs['id'] ?>" type="checkbox" value="<?= $row_prefs['id'] ?>" 
<?php 
			if (isset($user_prefs[$row_prefs['id']]) and $user_prefs[$row_prefs['id']]) 
				echo "checked=\"checked\""; 
?> /></td>
<?php
		break;
		case 'enum':
			$sql_get_enum = "SELECT opt, id FROM preferences_options WHERE pref_id = " . $row_prefs['id'];
			$sth_get_enum = mysql_query($sql_get_enum);
?>
			<td><select name="p<?= $row_prefs['id'] ?>">
					<?php
			while ($row_get_enum = mysql_fetch_assoc($sth_get_enum)) {
				if (isset($user_prefs[$row_prefs['id']]) and $user_prefs[$row_prefs['id']] == $row_get_enum['id']) {
?><option value="<?= $row_get_enum['id'] ?>" selected="selected"><?php
				} else {
?><option value="<?= $row_get_enum['id'] ?>"><?php } ?><?= $row_get_enum['opt']; ?></option>
					<?php
			}
?>
				</select></td>
<?php
		break;
		default:
?>
			<td><input name="p<?= $row_prefs['id'] ?>" type="text" value="
<?php
			if (isset($user_prefs[$row_prefs['id']])) echo $user_prefs[$row_prefs['id']];
?>" /></td>
<?php
		break;
	}
?>
	</tr>
<?php
}

?>
</table><br />
	<input type="submit" name="Submit" value="chang prefz" />
</form>
<a href="tagline.php">Edit My Taglines</a>
</body>
</html>
