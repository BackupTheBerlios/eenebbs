<?php

require_once 'lib/utils.php';
require_once 'lib/config.php';

session_start();
authenticate();

$sysopemail = SYSOPEMAIL;
$from = $_POST['from'];
$subject = $_POST['subject']; 
$body = $_POST['body'];

mail($sysopemail,$subject,$body);
echo "your feedback has been sent"

?>
