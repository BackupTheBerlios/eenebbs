<?php 
session_start();
require_once 'lib/config.php';
require_once 'lib/utils.php';

if (isset($_GET['error']) and $_GET['error'] == 'You are now logged out.') {
	if (isset($_SESSION['id'])) 
		myLog('LOGOUT', $_SESSION['id']);
	$_SESSION['logged_in'] = null;
	unset($_SESSION['logged_in']);
	$_SESSION['alias'] = null;
	unset($_SESSION['alias']);
	$_SESSION['id'] = null;
	unset($_SESSION['id']);
	$_SESSION['sl'] = null;
	unset($_SESSION['sl']);	
} else if (isset($_SESSION['id'])) {
	header("Location: http://" .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
			"/main_frames.php?login=true&newscan=true&sub=1");
}

$sql_get_motto = "SELECT motto FROM mottos ORDER BY RAND() LIMIT 1";
$row = @mysql_fetch_assoc(@mysql_query($sql_get_motto));


echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= BBSNAME ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="default.css" rel="stylesheet" type="text/css" />
</head>
<body class="main">
<?php displayErrors(); ?>
<form action="login.php" method="post" name="login" id="login">
<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="bgTable">
<table width="100%" border="0" cellspacing="1" cellpadding="8">
					<tr> 
						<td colspan="2" nowrap="nowrap" class="splashBBS"> 
							<?= BBSNAME ?>
						</td>
						<td width="100%" nowrap="nowrap" class="splashEene">eeneBBS 
							<?= VERSION ?>
						</td>
					</tr>
					<tr> 
						<td colspan="3" class="tagline"> 
							<div align="center"> 
								<?= $row['motto']; ?>
							</div></td>
					</tr>
					<tr> 
						<td class="msgTitle">NN:</td>
						<td width="100%" colspan="2" nowrap="nowrap" class="msgTable"><input name="alias" type="text" id="alias2" size="16" maxlength="32" />
							No account? <a href="signup.php">Sign up</a>! </td>
					</tr>
					<tr> 
						<td class="msgTitle">PW:</td>
						<td width="100%" colspan="2" class="msgTable"><input name="password" type="password" id="password3" size="16" maxlength="32" /> 
							<input name="login" type="submit" id="login3" value="Login" /> </td>
					</tr>
					<tr> 
						<td class="eene"  style="background-color: #EEEEEE;"></td>
						<td width="100%" class="eene" style="background-color: #EEEEEE;"><a href="http://eenebbs.berlios.de">eeneBBS 
							<?= VERSION ?>
							</a> </td>
						<td class="eene"  style="background-color: #EEEEEE;">This site requires 
							a frames-capable browser.</td>
					</tr>
				</table></td>
	</tr>
</table>
  <p>&nbsp; </p>
</form>

</body>
</html>
