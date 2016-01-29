<?php
	require_once 'class.PotionShop.php'; # Make sure you have the needed Class file
?><!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		
		<link rel="stylesheet" href="styles.css" />

		<title>Potion Shop Inventory</title>
	</head>
	
	<body>
		<h1>Potion Shop Inventory</h1>
		<?php
			# Check for success message trigger and display accordingly
			if( isset($_GET["success"]) ):
				switch($_GET["success"]):
					case "add":
						echo "<p class='success-add'>Potion added successfully.</p>";
						break;
						
					case "delete":
						echo "<p class='success-delete'>Potion removed successfully.</p>";
						break;
						
					case "edit":
						echo "<p class='success-edit'>Potion updated successfully.</p>";
						break;
				endswitch;
			endif;

			$myShop = new PotionShop; # Instantiate an Object using our PotionShop Class
			$myShop->displayPotions(); # Call the displayPotions method through the new Object
		?>
	</body>
</html>