<?php

require_once 'lib/utils.php';
require_once 'lib/config.php';

session_start();
authenticate();

foreach ($_POST as $name => $value) 
	$req[$name] = trim(clean($value, 255));

#debug($req);exit;

if (isset($req['new'])) {
	if (!isset($req['tagline']) or $req['tagline'] == '') {
		header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/tagline.php?success=false");
		exit;
	} else {
		$sql_add_tagline = "INSERT INTO taglines (tagline, user_id) VALUES ('" . $req['tagline'] . "', " . $_SESSION['id'] . ")";
		header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/tagline.php?success=" . @mysql_query($sql_add_tagline));
		exit;
	}
} else if (isset($req['set'])) {
	if (isset($req['display'])) {
		$sql_set_pref = "UPDATE user_preferences SET user_id = " $_SESSION['id'] . ", pref_id = 5, value = " . $req['display'];
		header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/tagline.php?success=" . mysql_query($sql_set_pref));
	} else {
		header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/tagline.php?success=false");
		exit;
	}
} else {
	foreach ($req as $key => $value) {
		preg_match("/(\d+)/", $key, $match);
		$id = $match[1];
		if ($value == 'Delete') {
			$sql_del_tagline = "DELETE FROM taglines WHERE id = " . $id;
			header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/tagline.php?success=" . mysql_query($sql_del_tagline));
			exit;
		} else if ($value == 'Change') {
			if (!isset($req['tagline' . $id]) or $req['tagline' . $id] == '') {
				header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/tagline.php?success=false");
				exit;				
			} else {
				$sql_change_tagline = "UPDATE taglines SET tagline = '" . $req['tagline' . $id] . "' WHERE id = " . $id;
				header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/tagline.php?success=" . mysql_query($sql_change_tagline));			
				exit;
			}
		} 
	} 
}
header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/tagline.php?success=false");
exit;
?>
