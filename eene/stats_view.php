<?php 
session_start();

require_once 'lib/config.php';
require_once 'lib/utils.php';

authenticate();
foreach ($_GET as $name => $value) 
	$req[$name] = trim(clean($value, 255));

$sql_get_stat = "SELECT s." . $req['stat'] . ", u.alias, u.id FROM stats s, users u WHERE u.id = 
		s.user_id AND u.sl <> 255 ORDER BY s." . $req['stat'] . " DESC LIMIT 10";
$sth_get_stat = @mysql_query($sql_get_stat);

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= BBSNAME ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body class="main">
<p><a href="stats.php">back to stats </a></p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="bgTable"><table width="100%" border="0" cellspacing="1" cellpadding="4">
				<tr> 
					<td class="msgTitle">Rank</td>
					<td class="msgTitle">Alias / #</td>
					<td nowrap="nowrap" class="msgTitle" width="100%">Total <?= $req['stat'] ?></td>
				</tr>
<?php
for ($i = 1; $i <= @mysql_num_rows($sth_get_stat); $i++) {
	$row_stats = @mysql_fetch_assoc($sth_get_stat);
?>
				<tr>
					<td class="msgTable"><?= $i ?>.</td>
					<td class="msgTable" nowrap="nowrap"><?= $row_stats['alias'] ?> #<?= $row_stats['id'] ?></td>
					<td class="msgTable" width="100%"><?= $row_stats[$req['stat']] ?></td>
				</tr>
<?php
}
?>
	</table></td>
	</tr>
</table>
</body>
</html>
