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
<?php

if (isset($_SESSION['success'])) {
?>
<body class="main" onload="parent.rightFrame.location.reload(true);">
<?php
} else {
	echo "<body class=\"main\">";
}
?>
<?php displayErrors(); ?>
<p>You can create as many subs as you wish, but please don't make too many unnecessary subs.</p>
<p>The maximum sub length is 64 characters, but try and limit this to 16.  If you wish to make an anonymous sub, go ahead and make your sub and then give <a href="feedback.php">feedback</a> to the sysop about it.</p>
<form name="form1" id="form1" method="post" action="addsub_validate.php">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="bgTable"><table width="100%" border="0" cellspacing="1" cellpadding="4">
					<tr>
						<td nowrap="nowrap" class="msgTitle">New sub name:</td>
						<td width="100%" class="msgTable"> 
							<input name="sub" type="text" id="sub" maxlength="64" />
						</td>
					</tr>
				</table></td>
		</tr>
	</table>
<p><input type="submit" name="Submit" value="Create Sub" /></p>
	
</form>
</body>
</html>