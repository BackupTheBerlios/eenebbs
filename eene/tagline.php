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
<form action="tagline_validate.php" method="post">
<p><a href="prefs.php">back to prefs menu</a></p>
<p>this is the taglines menu. OK.</p>
  <?php

$sql_get_taglines = "SELECT id, tagline FROM taglines WHERE user_id = " . $_SESSION['id'];
$sth_get_taglines = @mysql_query($sql_get_taglines);
if ($sth_get_taglines and @mysql_num_rows($sth_get_taglines) > 0) {
?>
	<p>Your taglines:</p>
<?php
	while ($row_get_taglines = @mysql_fetch_array($sth_get_taglines)) {
?>
	<input name="tagline<?= $row_get_taglines['id'] ?>" type="text" id="tagline<?= $row_get_taglines['id'] ?>" maxlength="255" value="<?= stripslashes($row_get_taglines['tagline']) ?>" /><input name="change<?= $row_get_taglines['id'] ?>" type="submit" value="Change"><input name="delete<?= $row_get_taglines['id'] ?>" type="submit" value="Delete"><br />
	
<?php
	}
?>
	</form>
<?php
} else {
?>
	<p>Looks like you don't have any taglines.</p>
<?php
}
?>
<p>You can add a tagline below. Image tags will 
		be discarded.  Max 255 chars.</p>
	<p> <form action="tagline_validate.php" method="post">
		<input name="tagline" type="text" id="tagline" maxlength="255" />
		<input name="Submit" type="submit" id="Submit" value="Add" />
		<input name="new" type="hidden" value="true" />
		</form>
	</p>
<p>How to display taglines?</p>
<form action="tagline_validate.php" method="post">
<input type="hidden" name="set" value="true" />
<p>
<?php

$sql_get_user_prefs = "SELECT value FROM user_preferences WHERE pref_id = 5 AND user_id = " . $_SESSION['id'];
$sth_get_user_prefs = mysql_query($sql_get_user_prefs);
$row_get_user_prefs = mysql_fetch_assoc($sth_get_user_prefs);

$sql_get_tagline_options = "SELECT po.opt, po.id FROM preferences_options po, preferences p WHERE p.short_descr = 'TAGLINES' AND po.pref_id = p.id ORDER BY id";
$sth_get_tagline_options = @mysql_query($sql_get_tagline_options);
while ($row_get_tagline_options = mysql_fetch_assoc($sth_get_tagline_options)) {
?> 
		<label>
<?php
if ($row_get_tagline_options['id'] == $row_get_user_prefs['value']) {
?>
		<input type="radio" checked="checked" name="display" value="<?= $row_get_tagline_options['id'] ?>" />
<?php
} else {
?>
		<input type="radio" name="display" value="<?= $row_get_tagline_options['id'] ?>" />
<?php
}
?>
		<?= $row_get_tagline_options['opt'] ?></label>
		<br />
<?php
}
?>
	</p>
	<p><input name="Submit" type="submit" id="Submit" value="Set" /></p>
</form></p>
</body>
</html>
