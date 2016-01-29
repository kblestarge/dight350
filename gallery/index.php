<?php
	require 'class.gallery.php';
	$Gallery = new Gallery;

	session_start();

	if ($_SESSION["login"] == true) {
		header("location: gallery.php");
	}
	if (isset($_POST["logout"])) {
		$_SESSION["login"] == false;
	}
	if (isset($_POST["username"]) && isset($_POST["password"])) {

		$Gallery->login($_POST["username"], $_POST["password"]);
	}
	if (isset($_GET["error"])) {
		echo "<p class='bg-danger'>Wrong username or password, try again or give up.</p>";
	}

?><!doctype html>
<html>

	<head>
		<title>Gallery Login</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	</head>

	<body id="login">
		<div class="center">
			<h1>Login</h1>
			<form  action="index.php" method="post">
				<br>
				<input type="text" name="username" placeholder="Username">
				<br>
				<br>
				<input type="password" name="password" placeholder="Password">
				<br><br>
				<input type="submit" value="Submit">
			</form>
		</div>
		
	</body>

</html>
