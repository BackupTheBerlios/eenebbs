<?php 

require_once 'lib/config.php';
require_once 'lib/utils.php';

session_start();
authenticate();

foreach ($_GET as $name => $value) 
	$req[$name] = trim(clean($value, 255));	

$sql_get_sub_name = "SELECT name FROM subs WHERE id = " . $_SESSION['sub'];
$sth_get_sub_name = @mysql_query($sql_get_sub_name);
$row_get_sub_name = @mysql_fetch_assoc($sth_get_sub_name);
$sub_name = $row_get_sub_name['name'];

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= BBSNAME ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body class="main">

<form action="post_validate.php" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td class="bgTable"><table width="100%" cellpadding="4" cellspacing="1">
					<tr> 
						<td class="msgTitle">From
							#<?= $_SESSION['id'] ?> <strong><?= $_SESSION['alias'] ?></strong>
							on about 
							<?= date("F j, Y, g:i a") ?> : 
							</td>
					</tr>
					<tr> 
						<td class="msgText"><textarea name="message" cols="64" rows="8" id="message" wrap="soft"></textarea> 
						</td>
					</tr>
					<tr> 
						<td class="msgText"><input type="submit" name="Submit" value="Post Message to &quot;<?= $sub_name ?>&quot; " /> 
						</td>
					</tr>
				</table></td>
	</tr>
</table>
</form>
</body>
</html>
