<?php

require_once 'lib/utils.php';
require_once 'lib/config.php';

session_start();
authenticate();

foreach ($_POST as $name => $value) 
	$req[$name] = trim(clean($value, 255));

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
		$sql_set_pref = "UPDATE user_preferences SET value = " . $req['display'] . " WHERE user_id = " . $_SESSION['id'] . " AND pref_id = 5";
		header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/tagline.php?success=" . @mysql_query($sql_set_pref));
	} else {
		header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/tagline.php?success=false");
		exit;
	}
} else {
	foreach ($req as $key => $value) {
		preg_match("/(\d+)/", $key, $match);
		$tag_id = $match[1];
		if ($value == 'Delete') {
			$sql_del_tagline = "DELETE FROM taglines WHERE id = " . $tag_id;
			header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/tagline.php?success=" . @mysql_query($sql_del_tagline));
			exit;
		} else if ($value == 'Change') {
			if (!isset($req['tagline' . $tag_id]) or $req['tagline' . $tag_id] == '') {
				header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/tagline.php?success=false");
				exit;				
			} else {
				$sql_change_tagline = "UPDATE taglines SET tagline = '" . $req['tagline' . $tag_id] . "' WHERE id = " . $tag_id;
				header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/tagline.php?success=" . @mysql_query($sql_change_tagline));			
				exit;
			}
		} 
	} 
}
header("Location: http://".$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/tagline.php?success=false");
exit;
?>
