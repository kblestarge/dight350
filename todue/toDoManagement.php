<?php
	require_once 'class.toDoInput.php';
	
	$myList = new toDoList;

	$error = 0;

	# Setup page information and execute code based on which button was pressed
	switch ( $_POST["btn_action"] ):
		case "Add Item":
			$btn_value = "Add Item";
			$action = "add";
			break;

		case "Delete Item":
			if ( !$_POST["Itemid"] ):
				header("location: index.php");
				exit;
			endif;

			$myList->removeItem($_POST["Itemid"]);
			break;
			
		#This doesnt work yet
		case "Change completion":
			if ( !$_POST["Itemid"] ):
				if ( $complete ):
					$complete = 0;
				else:
					$complete = 1;
				endif;

				header("location: index.php");
				exit;
			endif;
			break;
		
		case "Edit Item":

			if ( !$_POST["Itemid"] ):
				header("location: index.php");
				exit;
			endif;
			
			$btn_value = "Edit Item";
			$action = "edit";

			$edit_Item = $myList->singleItem($_POST["Itemid"]);
			
			foreach( $edit_Item as $key => $value ):
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
					$myList->addItem($priority, $description, $complete);
					break;

				case "edit":
					$myList->editItem($Itemid, $priority, $description, $complete);
					break;
			endswitch;
		endif;
	endif;



?><!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

		<link rel="stylesheet" href="styles.css" />

		<title>Add Item</title>
	</head>
	
	<body class="bk">

		<div class="centered2 bk3">

			<p><a class="return" href="index.php">&laquo; Back</a></p>
			
			<h1><?=$action;?> Item</h1>

			<br>
			
			<?php
				if ($error > 0):
					echo "<p class='error'>Please fill out all the fields.</p>";
				endif;
			?>

			<form name="management" id="management" method="post">
				<fieldset>
					
					<input type="hidden" name="form_action" value="<?=$action;?>" />

					<?php if ( isset($Itemid) ): ?>
						<input type="hidden" name="Itemid" value="<?=$Itemid;?>" />
					<?php endif; ?>

					<p>
						<label for="priority">Priority:</label>
						<select name="priority">
						  <option value="1" <?=(isset($priority)&&$priority=="1")?"selected=\"selected\"":"";?>>1</option>
						  <option value="2" <?=(isset($priority)&&$priority=="2")?"selected=\"selected\"":"";?>>2</option>
						  <option value="3" <?=(isset($priority)&&$priority=="3")?"selected=\"selected\"":"";?>>3</option>
						  <option value="4" <?=(isset($priority)&&$priority=="4")?"selected=\"selected\"":"";?>>4</option>
						  <option value="5" <?=(isset($priority)&&$priority=="5")?"selected=\"selected\"":"";?>>5</option>
						</select>
					</p>
					
					<p>
						<label for="description">Description:</label>
						<input type="text" name="description" value="<?=(isset($description)?$description:"");?>" />
					</p>
					
					<p>
						<label for="complete">Complete:</label>
						Yes <input type="radio" name="complete" value="1" <?=(isset($complete)&&$complete)?"checked":"";?> />
						No <input type="radio" name="complete" value="0" <?=(isset($complete)&&!$complete)?"checked":"";?> />
					</p>

					<input type="submit" name="btn_action" class="btn_action <?=$action;?>" value="<?=$btn_value;?>" />
				</fieldset>
			</form>
		</div>
	</body>
</html>