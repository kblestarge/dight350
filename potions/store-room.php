<?php
	require_once 'code-engine.php';

	$error = 0;
	
	if ( !empty($_POST["btn_addPotion"]) ):
		foreach( $_POST as $key => $value ):
			${$key} = $value;
			
			if ( $value == "" ):
				$error++;
			endif;
		endforeach;
		
		if ($error == 0):
			$insert_query = "
				INSERT INTO
					potions
					(name, color, toxic, quantity, intended_effects, side_effects)
				VALUES
					(?, ?, ?, ?, ?, ?)
			";
			
			if ( $newPotion = $connection->prepare($insert_query) ):
				$newPotion->bind_param(
					'ssiiss',
					$potion_name, $potion_color, $toxic, $quantity, $intended_effects, $side_effects
				);
				
				$newPotion->execute();
				
				$newPotion->close();
				
				header("location: index.php?addSuccess");
			endif;
		endif;
	endif;
?><!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		
		<title>Add a new Potion</title>
	</head>
	
	<body>
		<p><a href="index.php">Home</a></p>
		
		<h1>Add a new Potion</h1>
		
		<?php
			if ($error > 0):
				echo "<p>Please fill out all the fields.</p>";
			endif;
		?>

		<form name="add_potion" method="post">
			<fieldset>
				<legend>Potion Details</legend>
				
				<p>
					<label for="potion_name">Name:</label>
					<input type="text" name="potion_name" value="<?=(isset($potion_name)?$potion_name:"");?>" />
				</p>
				
				<p>
					<label for="potion_color">Color:</label>
					<input type="text" name="potion_color" value="<?=(isset($potion_color)?$potion_color:"");?>" />
				</p>
				
				<p>
					<label for="intended_effects">Intended Effects:</label>
					<input type="text" name="intended_effects" value="<?=(isset($intended_effects)?$intended_effects:"");?>" />
				</p>

				<p>
					<label for="side_effects">Side Effects:</label>
					<input type="text" name="side_effects" value="<?=(isset($side_effects)?$side_effects:"");?>" />
				</p>

				<p>
					<label for="toxic">Toxic:</label>
					Yes <input type="radio" name="toxic" value="1" />
					No <input type="radio" name="toxic" value="0" />
				</p>
				
				<p>
					<label for="quantity">Quantity:</label>
					<input type="text" name="quantity" value="<?=(isset($quantity)?$quantity:"");?>" />
				</p>

				<p>
					<input type="submit" name="btn_addPotion" value="Add to Inventory" />
				</p>
			</fieldset>
		</form>
	</body>
</html>