<?php
	require_once 'class.toDoInput.php'; # Make sure you have the needed Class file
?><!doctype html>
<html>
	<head>
		<meta charset="utf-8" />

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

		<link rel="stylesheet" href="styles.css" />

		<title>To Do</title>
	</head>
	
	<body class="bk">
		<div class="centered bk2">

			<h1 style="text-align:center;">To Do List</h1>
			
				<?php
					# Check for success message trigger and display accordingly
					if( isset($_GET["success"]) ):
						switch($_GET["success"]):
							case "add":
								echo "<p class='success-label'>item added successfully.</p>";
								break;
								
							case "delete":
								echo "<p class='success-label'>item removed successfully.</p>";
								break;
								
							case "edit":
								echo "<p class='success-label'>item updated successfully.</p>";
								break;
						endswitch;
					endif;
				?>
				
			<div class="bk3">
				<?php
					$myList = new toDoList; # Instantiate an Object using our toDoList Class
					$myList->displayItems(); # Call the displayPotions method through the new Object
				?>
			</div>
		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

		<script type="text/javascript" src="script.js"></script>
		
	</body>
</html>