<?php
	require_once 'class.PotionShop.php';
	
	$myShop = new PotionShop;

	$error = 0;

	# Setup page information and execute code based on which button was pressed
	switch ( $_POST["btn_action"] ):
		case "Add Potion":
			$btn_value = "Add Potion";
			$action = "add";
			break;

		case "Delete Potion":
			if ( !$_POST["potion_id"] ):
				header("location: index.php");
				exit;
			endif;

			$myShop->removePotion($_POST["potion_id"]);
			break;
		
		case "Edit Potion":
			if ( !$_POST["potion_id"] ):
				header("location: index.php");
				exit;
			endif;

			$btn_value = "Edit Potion";
			$action = "edit";

			$edit_potion = $myShop->singlePotion($_POST["potion_id"]);

			foreach( $edit_potion as $key => $value ):
				${$key} = $value;
			endforeach;
			break;

		default:
			header("location: index.php");
			break;
	endswitch;

	# Process the form submission here
	if ( !empty($_POST["form_action"]) ):
		foreach( $_POST as $key => $value ):
			${$key} = $value;
			
			if ( $value == "" ):
				$error++;
			endif;
		endforeach;

		if ($error == 0):
			switch ( $_POST["form_action"] ):
				case "add":
					$myShop->addPotion($potion_name, $potion_color, $toxic, $quantity, $intended_effects, $side_effects);
					break;

				case "edit":
					$myShop->editPotion($potion_id, $potion_name, $potion_color, $toxic, $quantity, $intended_effects, $side_effects);
					break;
			endswitch;
		endif;
	endif;
?><!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		
		<link rel="stylesheet" href="styles.css" />

		<title>Potion Storeroom</title>
	</head>
	
	<body>
		<p><a class="return" href="index.php">&laquo; Back to Inventory</a></p>
		
		<h1>Potion Storeroom</h1>
		
		<?php
			if ($error > 0):
				echo "<p class='error'>Please fill out all the fields.</p>";
			endif;
		?>

		<form name="storeroom" id="storeroom" method="post">
			<fieldset>
				<legend>Potion Details</legend>
				
				<input type="hidden" name="form_action" value="<?=$action;?>" />

				<?php if ( isset($potion_id) ): ?>
					<input type="hidden" name="potion_id" value="<?=$potion_id;?>" />
				<?php endif; ?>

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
					Yes <input type="radio" name="toxic" value="1" <?=(isset($toxic)&&$toxic)?"checked":"";?> />
					No <input type="radio" name="toxic" value="0" <?=(isset($toxic)&&!$toxic)?"checked":"";?> />
				</p>
				
				<p>
					<label for="quantity">Quantity:</label>
					<input type="text" name="quantity" value="<?=(isset($quantity)?$quantity:"");?>" />
				</p>

				<input type="submit" name="btn_action" class="btn_action <?=$action;?>" value="<?=$btn_value;?>" />
			</fieldset>
		</form>
	</body>
</html>