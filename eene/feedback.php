<?php 

require_once 'lib/config.php';
require_once 'lib/utils.php';

session_start();

$sql_get_user_info = "SELECT email FROM users WHERE id = " . $_SESSION['id'];
$sth_get_user_info = mysql_query($sql_get_user_info);
$row_user_info = mysql_fetch_assoc($sth_get_user_info);

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>

<p>Send us your comments, suggestions, complaints, etc.<p>

<form action="feedback_send.php" method="post">
	From: <input name="from" type=text value="<?= $row_user_info['email'] ?>" /><p>

	Subject: <input name="subject" type=text value="bbs feedback"><p>
	<textarea name="body" rows=20 cols=40 wrap="soft"></textarea>
	<br />
	<input type="submit" name="Submit" value="send it johnny" />
</form>
<p>&nbsp; </p>
</body>
</html>
