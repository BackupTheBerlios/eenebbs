<?php 

require_once 'lib/utils.php';
require_once 'lib/config.php';

session_start();
authenticate();

$sql_vtopics = "SELECT id, name FROM voting_topics ORDER BY date DESC";

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body class="main">

<p>look its a voting booth.</p>
<ul>
<?php

$sth_vtopics = @mysql_query($sql_vtopics);
while ($row = mysql_fetch_assoc($sth_vtopics)) {
?>
<li><a href="voting_vote.php?id=<?= $row['id'] ?>"><?= $row['name'] ?></li>
<?php } ?>
</ul>
<p><a href="voting_add.php">add a topic</a></p>

</body>
</html>
