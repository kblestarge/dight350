<!DOCTYPE html>
<html>
<head>
<title></title>
</head>
<body>

<?php

	session_start();

	if( $SESSION["login"]):
		header("location: LoginConf.php");
	endif;

	if(!empty($_POST)):
		
?>

	<form  action="LoginConf.php" method="post">
		Username:
		<br>
		<input type="text" name="username" value="username">
		<br>
		Password:<br>
		<input type="password" name="password" value="password">
		<br><br>
		<input type="submit" value="Submit">
	</form>

</body>
</html>