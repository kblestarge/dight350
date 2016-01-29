
Welcome <?php echo $_POST["username"]; ?><br>
Your password is: <?php echo $_POST["password"]; ?>

<?php

	public function __construct() {
		# New mysqli Object for database communication
		$this->database = new mysqli("localhost", "tardissh_kles", "8608!", "tardissh_lestarge");

		# Kill the page is there was a problem with the database connection
		if ( $this->database->connect_error ):
			die( "Connection Error! Error: " . $this->database->connect_error );
		endif;
	}
	
	session_start();

	if( !$_SESSION["login"]):
		header("location: index.php");
	endif;

	$hashed_password = hash('whirlpool', $_POST['password']."salt");

	echo "<br>";
	echo $hashed_password;
?>

