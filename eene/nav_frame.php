<?php

require_once 'lib/config.php';
require_once 'lib/utils.php';
session_start();
authenticate();

function _getSubs() {
	$sql_get_subs = "SELECT * FROM subs ORDER BY id";
	return @mysql_query($sql_get_subs);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title><?= BBSNAME ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="default.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
function jumpSub() {
	document.navbar.submit();
	parent.rightFrame.location.reload(true);
}
</script>
</head>

<body class="navbar">
<form name="navbar" id="navbar" method="post" action="main.php?order=desc" target="mainFrame">
	<p align="center" class="navbar"><strong> 
		<?= BBSNAME ?>
		</strong></p>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td class="bgTable"> 
				<table width="100%" border="0" cellspacing="1" cellpadding="4">
					<tr> 
						<td nowrap="nowrap" class="navbarTable"><a href="main.php?newscan=true" target="mainFrame" onclick="parent.rightFrame.location.reload(true);"><strong>Newscan 
							Next Sub</strong></a></td>
					</tr>
					<tr> 
						<td nowrap="nowrap" class="navbarTable"><strong><a href="post.php?sub=<?= $_SESSION['sub'] ?>" target="mainFrame">Post 
							a Message</a></strong></td>
					</tr>
					<tr> 
						<td nowrap="nowrap" class="navbarTable"><a href="main.php?order=asc" target="mainFrame" onclick="parent.rightFrame.location.reload(true);">Read 
							Sub Forwards</a></td>
					</tr>
					<tr> 
						<td nowrap="nowrap" class="navbarTable"><a href="main.php?order=desc" target="mainFrame" onclick="parent.rightFrame.location.reload(true);">Read 
							Sub Backwards</a></td>
					</tr>
					<tr> 
						<td nowrap="nowrap" class="navbarTable"> Jump to Sub:<br /> 
							<select name="sub" size="8" class="navBarJump" onchange="javascript:jumpSub();">
<?php
$sth_get_subs = _getSubs();
while ($row_get_subs = @mysql_fetch_assoc($sth_get_subs)) {
	$option = (strlen($row_get_subs['name']) > 16) ? substr($row_get_subs['name'], 0, 16)
			. '...' : $row_get_subs['name'];
	if ($row_get_subs['id'] == $_SESSION['sub']) {
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
							to Sysop</a></td>
					</tr>
					<tr>
						<td nowrap="nowrap" class="navbarTable"><a href="lastusers.php" target="mainFrame">Last Users</a>
						</td>
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
						<td class="navbarTable"><a href="index.php?error=You+are+now+logged+out." target="_top">Logout 
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
