<?php 

require_once 'lib/config.php';
require_once 'lib/utils.php';

session_start();
authenticate();

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body class="main">
<p><a href="main.php">back to main</a> / <a href="voting_booth.php">back to voting 
	booth</a> </p>
<p>ok. you know how this works.</p>
<form name="form1" id="form1" method="post" action="voting_add_validate.php">
	topic/question: 
	<input name="topic" type="text" id="topic" />
	<br />
	option 1: 
	<input name="o1" type="text" id="o1" />
	<br />
	option 2: 
	<input name="o2" type="text" id="o2" />
		<br />
	option 3: 
	<input name="o3" type="text" id="o3" />
		<br />
	option 4: 
	<input name="o4" type="text" id="o4" />
		<br />
	option 5: 
	<input name="o5" type="text" id="o5" />
		<br />
	option 6: 
	<input name="o6" type="text" id="o6" />
		<br />
	option 7: 
	<input name="o7" type="text" id="o7" />
		<br />
	option 8: 
	<input name="o8" type="text" id="o8" />
		<br />
	option 9: 
	<input name="o9" type="text" id="o9" />
		<br />
	option 10: 
	<input name="o10" type="text" id="o10" />
	<br />
	<input name="add this one" type="submit" id="add this one" value="Submit" />
</form>
<p>&nbsp;</p>
</body>
</html>
