<?php

require_once 'lib/utils.php';
require_once 'lib/config.php';

session_start();

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= BBSNAME ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body class="main">
<?php displayErrors(); ?>
<p>Publicly displayed user information:</p>
<?php

$sql_get_user_info = "SELECT location, email, site FROM users WHERE id = " . $_SESSION['id'];
$sth_get_user_info = @mysql_query($sql_get_user_info);
$row_user_info = @mysql_fetch_assoc($sth_get_user_info);
?>
<form action="prefs_validate.php" method="post">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="bgTable"><table border="0" cellpadding="4" cellspacing="1" width="100%">
					<tr> 
						<td nowrap="nowrap" class="msgTitle">Location</td>
						<td width="100%" class="msgText"> 
							<input name="location" type="text" id="location" value="<?= $row_user_info['location'] ?>" size="32" maxlength="128" /></td>
					</tr>
					<tr> 
						<td nowrap="nowrap" class="msgTitle">Email</td>
						<td width="100%" class="msgText"> 
							<input name="email" type="text" id="email" value="<?= $row_user_info['email'] ?>" size="32" maxlength="128" /></td>
					</tr>
					<tr> 
						<td height="32" nowrap="nowrap" class="msgTitle">Website</td>
						<td width="100%" class="msgText">http:// 
							<input name="site" type="text" id="site" value="<?= $row_user_info['site'] ?>" size="32" maxlength="255" /></td>
					</tr>
				</table></td>
		</tr>
	</table>
	<p>User Preferences:</p>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="bgTable"><table border="0" cellpadding="4" cellspacing="1">
					<?php

$sql_get_prefs = "SELECT * FROM preferences";
$sth_get_prefs = @mysql_query($sql_get_prefs);
$user_prefs = getUserPrefs($_SESSION['id']);
while ($row_prefs = @mysql_fetch_assoc($sth_get_prefs)) {
?>
					<tr> 
						<td nowrap="nowrap" class="msgTitle"> 
							<?= $row_prefs['descr']?>
						</td>
						<?php	
	switch ($row_prefs['type']) {
		case 'bit':
?>
						<td width="100%" class="msgText"> 
							<input name="p<?= $row_prefs['id'] ?>" type="checkbox" value="<?= $row_prefs['id'] ?>" 
<?php 
			if (isset($user_prefs[$row_prefs['id']]) and $user_prefs[$row_prefs['id']]) 
				echo "checked=\"checked\""; 
?> /></td>
						<?php
		break;
		case 'enum':
			$sql_get_enum = "SELECT opt, id FROM preferences_options WHERE pref_id = " . $row_prefs['id'];
			$sth_get_enum = @mysql_query($sql_get_enum);
?>
						<td width="100%" class="msgText"> 
							<select name="p<?= $row_prefs['id'] ?>">
								<?php
			while ($row_get_enum = @mysql_fetch_assoc($sth_get_enum)) {
				if (isset($user_prefs[$row_prefs['id']]) and $user_prefs[$row_prefs['id']] == $row_get_enum['id']) {
?>
								<option value="<?= $row_get_enum['id'] ?>" selected="selected">
								<?php
				} else {
?>
								</option>
								<option value="<?= $row_get_enum['id'] ?>">
								<?php } ?>
								<?= $row_get_enum['opt']; ?>
								</option>
								<?php
			}
?>
							</select></td>
						<?php
		break;
		default:
?>
						<td width="100%" class="msgText"> 
							<input name="p<?= $row_prefs['id'] ?>" type="text" value="
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
				</table></td>
		</tr>
	</table>
	<br />
	<input type="submit" name="Submit" value="Save All Changes" />
</form>
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="bgTable"><table border="0" cellspacing="1" cellpadding="4">
				<tr>
					<td nowrap="nowrap" class="navbarTable"><a href="tagline.php">Tagline Menu</a></td>
					<td class="navbarTable"><a href="passwd.php">Change Password</a></td>
				</tr>
			</table></td>
	</tr>
</table>
</body>
</html>
