<?php

require_once 'lib/utils.php';
require_once 'lib/config.php';

session_start();
authenticate();

$sysopemail = SYSOPEMAIL;
$from = $_POST['from'];
$subject = "bbs feedback" . " from " . $from;  
$body = $_POST['body'];

mail($sysopemail,$subject,$body);

?>

<html>
<head>
<title><?= BBSNAME ?></title>
</head>
<body class="main">
<p>Your feedback has been sent!<p>
</body></html>
