<?php 

session_start();
require 'lib/config.php';
require 'lib/utils.php';
authenticate();

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= BBSNAME ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body class="main">
<p>here are your numbers.</p>
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="bgTable"><table width="100%" border="0" cellspacing="1" cellpadding="4">
				<tr> 
					<td class="navbarTable"><a href="stats_view.php?stat=logins">Top 10 
						Callers</a></td>
				</tr>
				<tr> 
					<td class="navbarTable"><a href="stats_view.php?stat=posts">Top 10 Posters</a></td>
				</tr>
				<tr> 
					<td class="navbarTable"><a href="stats_view.php?stat=mottos">Top 10 
						Motto Writers</a></td>
				</tr>
				<tr> 
					<td class="navbarTable"><a href="stats_view.php?stat=automessages">Top 
						10 Automessage Writers</a></td>
				</tr>
				<tr> 
					<td class="navbarTable"><a href="stats_view.php?stat=subs">Top 10 Sub 
						Creators</a></td>
				</tr>
				<tr>
					<td class="navbarTable"><a href="stats_system.php">System Statistics</a></td>
				</tr>
			</table></td>
	</tr>
</table>

</body>
</html>
