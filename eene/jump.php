<?php

require_once 'lib/config.php';
require_once 'lib/utils.php';
session_start();
authenticate();

function _getSubs() {
	$sql_get_subs = "SELECT * FROM subs ORDER BY id";
	return @mysql_query($sql_get_subs);
}

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= BBSNAME ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>


<body class="main">
<p>Jump to Sub:</p>
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="bgTable"><table width="100%" border="0" cellspacing="1" cellpadding="4">
<?php
$sth_get_subs = _getSubs();
$subs = array();
while ($row_get_subs = @mysql_fetch_assoc($sth_get_subs)) {
	$subs[] = array('name'=>$row_get_subs['name'], 'id'=>$row_get_subs['id']);
}

$count = 0;
for ($i = 0; $i < count($subs); $i++) {
	if ($i % 3 == 0) 
		echo '<tr>';
?>
		<td nowrap="nowrap" class="navbarTable">
			<a href="main.php?order=desc&sub=<?= $subs[$i]['id'] ?>"><?= $subs[$i]['name'] ?></a>
		</td>
<?php
	if ($i + 1 % 3 == 0) 
		echo '</tr>';
	$count = $i;
}
if ($count % 3 != 0) 
	echo '</tr>';
	
?>
			</table></td>
	</tr>
</table>

</body>
</html>
