<?php

require_once 'lib/config.php';
require_once 'lib/utils.php';

session_start();
authenticate();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title><?= BBSNAME ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="default.css" rel="stylesheet" type="text/css">
</head>

<body class="navbar">
<form name="navbar" id="navbar" method="post" action="main.php" target="mainFrame">
	<p align="center"><strong> 
		<?= BBSNAME ?>
		</strong></p>
	<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td bgcolor="#BBBBBB"> 
				<table width="100%" border="0" cellspacing="1" cellpadding="4">
					<tr> 
						<td nowrap="nowrap" class="navbarTable"><a href="main.php?newscan=true" target="mainFrame"><strong>Newscan 
							Next Sub</strong></a></td>
					</tr>
					<tr> 
						<td nowrap="nowrap" class="navbarTable"><strong><a href="post.php?sub=<?= $_SESSION['sub'] ?>" target="mainFrame">Post 
							a Message</a></strong></td>
					</tr>
					<tr> 
						<td nowrap="nowrap" class="navbarTable"><a href="main.php?order=asc" target="mainFrame">Read 
							Sub Forwards</a></td>
					</tr>
					<tr> 
						<td nowrap="nowrap" class="navbarTable"><a href="main.php?order=desc" target="mainFrame">Read 
							Sub Backwards</a></td>
					</tr>
					<tr> 
						<td nowrap="nowrap" class="navbarTable"> <select name="sub" size="8" class="msgTable" style="cursor:pointer;cursor:hand;" onchange="javascript:document.navbar.submit()">
								<?php
$sth_get_subs = getSubs();
while ($row_get_subs = mysql_fetch_assoc($sth_get_subs)) {
	$option = (strlen($row_get_subs['name']) > 18) ? substr($row_get_subs['name'], 0, 18)
			. '...' : $row_get_subs['name'];
	if ($_SESSION['sub'] == $row_get_subs['id']) {
?>
								<option value="<?= $row_get_subs['id'] ?>" selected="selected"><?= $option ?></option>
								<?php
	} else {
?>
								<option value="<?= $row_get_subs['id'] ?>"><?= $option ?></option>
								<?php
	}
}
?>
							</select> </td>
					</tr>
					<tr> 
						<td nowrap="nowrap" class="navbarTable"><a href="motto.php" target="mainFrame">Add 
							a Motto</a></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="navbarTable"><a href="addsub.php" target="mainFrame">Add a 
							Sub</a></td>
					</tr>
					<tr> 
						<td nowrap="nowrap" class="navbarTable"><a href="automessage.php" target="mainFrame">AutoMessage</a></td>
					</tr>
					<tr> 
						<td nowrap="nowrap" class="navbarTable"><a href="feedback.php" target="mainFrame">Feedback 
							to Sysop</a> </td>
					</tr>
					<tr> 
						<td nowrap="nowrap" class="navbarTable"><a href="prefs.php" target="mainFrame">Preferences</a></td>
					</tr>
					<tr> 
						<td nowrap="nowrap" class="navbarTable"><a href="stats.php" target="mainFrame">Top 
							Statistics</a></td>
					</tr>
					<tr> 
						<td nowrap="nowrap" class="navbarTable"><a href="users.php" target="mainFrame">User 
							List</a></td>
					</tr>
					<tr> 
						<td nowrap="nowrap" class="navbarTable"><a href="voting_booth.php" target="mainFrame">Voting 
							Booth</a></td>
					</tr>
					<?php
if ($_SESSION['sl'] == SYSOP_SL) {
?>
					<tr> 
						<td nowrap="nowrap" class="navbarTable"><a href="sysop.php" target="mainFrame">Sysop 
							Menu</a></td>
					</tr>
					<?php
}
?>
					<tr> 
						<td class="navbarTable"><a href="logout.php" target="_top">Logout 
							<strong> 
							<?= $_SESSION['alias'] ?>
							</strong> </a></td>
					</tr>
				</table></td>
		</tr>
	</table>
	<p class="eene"><a href="<?= EENELINK ?>" target="_top">eeneBBS</a> 
		v<?= VERSION ?>
	</p>
</form>
</body>
</html>
