<?php 
session_start();

require_once 'lib/config.php';
require_once 'lib/utils.php';

authenticate();
foreach ($_GET as $name => $value) 
	$req[$name] = trim(clean($value, 255));

$sql_get_stat = "SELECT s." . $req['stat'] . ", u.alias FROM stats s, users u WHERE u.id = 
		s.user_id ORDER BY s." . $req['stat'] . " DESC LIMIT 10";
$sth_get_stat = @mysql_query($sql_get_stat);

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body class="main">
<p><a href="stats.php">back to stats </a></p>
<ol>
<?php
while ($row_stats = mysql_fetch_assoc($sth_get_stat)) {
?>
	<li><?= $row_stats['alias'] ?> : <?= $row_stats[$req['stat']] ?></li>
<?php
}
?>
</ol>
</body>
</html>
