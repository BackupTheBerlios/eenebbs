<?php 

require_once 'lib/config.php';
require_once 'lib/utils.php';
session_start();
authenticate();

$sql_get_num_mottos = "SELECT COUNT(motto) FROM mottos";
$row = @mysql_fetch_assoc(@mysql_query($sql_get_num_mottos));

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
<p>Searches are case insensitive.  If any part of your phrase is found, results will be returned.  If too many messages have the word you are searching for, you will not get results.</p>
<form name="form1" id="form1" method="post" action="search_find.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="bgTable">
		<tr>
			<td><table width="100%" border="0" cellspacing="1" cellpadding="4">
					<tr> 
						<td nowrap="nowrap" class="msgTitle">Search (max 255 chars.):</td>
						<td width="100%" class="msgText"> <input name="search" type="text" id="motto" size="32" maxlength="255" /></td>
					</tr>
				</table></td>
		</tr>
	</table>
	<p> 
		<input type="submit" name="Submit" value="Search Messages" />
	</p>
</form>
<p>&nbsp; </p>
</body>
</html>
