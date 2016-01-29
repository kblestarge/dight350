<?php
	$connection = new mysqli("localhost","tardissh_demo","1234!","tardissh_demo");

	if ( $connection->connect_error ):
		die( "Connection Error! Error: " . $connection->connect_error );
	endif;

	$query = "
		SELECT 
			name,color,toxic,quantity,intended_effects,side_effects
		FROM
			potions
		ORDER BY
			name
	";

	if ( $potions = $connection->prepare($query) ):
		$potions->execute();
	
		$potions->store_result();

		$potions->bind_result($name,$color,$toxic,$quantity,$intended_effects,$side_effects);
	else:
		die ( "Bad query" );
	endif;
?>