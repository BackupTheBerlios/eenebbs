<?php 

session_start();
require 'lib/config.php';
require 'lib/utils.php';
authenticate();

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body class="main">

<p>here are your numbers.</p>
<ul>
	<li><a href="stats_view.php?stat=logins">Top 10 Callers</a></li>
	<li><a href="stats_view.php?stat=posts">Top 10 Posters</a></li>
	<li><a href="stats_view.php?stat=mottos">Top 10 Motto Writers</a></li>
	<li><a href="stats_view.php?stat=automessages">Top 10 Automessage Writers</a></li>
	<li><a href="stats_view.php?stat=subs">Top 10 Sub Creators</a></li>
</ul>
</body>
</html>
