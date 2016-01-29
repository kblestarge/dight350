<?php
	include("base.php");
	require_once 'class.postInput.php';
	
	$myList = new PostListClass;

	$error = 0;

	# Setup page information and execute code based on which button was pressed
	switch ( $_POST["btn_action"] ):
		case "Add Post":
			$btn_value = "Add Post";
			$action = "Add";
			break;

		case "Remove Post":
			if ( !$_POST["id"] ):
				header("location: index.php");
				exit;
			endif;
			
			$myList->removeItem($_POST["id"]);
			break;
		
		case "Edit":

			if ( !$_POST["id"] ):
				header("location: index.php");
				exit;
			endif;
			
			$btn_value = "Save Changes";
			$action = "Edit";

			$edit_post = $myList->singlePost($_POST["id"]);

			foreach( $edit_post as $key => $value ):
				${$key} = $value;
			endforeach;
			break;

		case "History":	
			header("location: index.php?filter=History");
			break;

		case "Art":	
			header("location: index.php?filter=Art");
			break;

		case "Database":	
			header("location: index.php?filter=Database");
			break;

		case "Archiving":
			header("location: index.php?filter=Archiving");
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

			$TagExArray = array();
			if(isset($History)):
				array_push($TagExArray, $History);
			endif;
			if(isset($Art)):
				array_push($TagExArray, $Art);
			endif;
			if(isset($Archiving)):
				array_push($TagExArray, $Archiving);
			endif;
			if(isset($Database)):
				array_push($TagExArray, $Database);
			endif;

			$Newid = $myList->maxPostid() + 1;

			switch ( $_POST["form_action"] ):
				case "Add":

					$myList->addPost($commentary, $title, $status, $link, $Newid, $TagExArray);
					break;

				case "Edit":
					$Postid2 = $Postid;
					$myList->editPost($Postid, $commentary, $title, $status, $link, $TagExArray, $Postid2);
					break;
			endswitch;
		endif;
	endif;



?><!doctype html>
<html>
	<?php startblock('content') ?>
		<div class="centered2 bk3">
			
			<?php
				if ($error > 0):
					echo "<p class='error'>Please fill out all the fields.</p>";
				endif;
			?>

			<form name="editForm" id="editForm" method="post">
				<fieldset>
					
					<input type="hidden" name="form_action" value="<?=$action;?>" />

					<?php if ( isset($Postid) ): ?>
						<input type="hidden" name="Postid" value="<?=$Postid;?>" />
					<?php endif; ?>

					<p>
						<input type="text" class="form-control" id="title_edit" placeholder="Title" name="title" value="<?=(isset($title)?$title:"");?>" />
					</p>

					<p>
						<input type="text" class="form-control" id="link_edit" placeholder="Link to article" name="link" value="<?=(isset($link)?$link:"");?>" />
					</p>

					<p>
						<textarea class="form-control" id="commentary_edit" placeholder="Comments go here" name="commentary" value="<?=(isset($commentary)?$commentary:"");?>">
<?=(isset($commentary)?$commentary:"");?></textarea>
					</p>
					
					<?php 
						if(isset($allTags)):

							$tagsArray = explode(", ", $allTags);

							foreach( $tagsArray as &$value ):
								switch( $value ):
									case "History":
										$History = "History";
										break;
									case "Art":
										$Art = "Art";
										break;
									case "Database":
										$Database = "Database";
										break;
									case "Archiving":
										$Archiving = "Archiving";
										break;
								endswitch;
							endforeach;
						endif;
					?>
					<div class="tags_edit">
						<label>Tags:</label><br>
						<input type="checkbox" name="History" value="1" <?=(isset($History)&&$History)?"checked":"";?> /> History<br>
						<input type="checkbox" name="Art" value="2" <?=(isset($Art)&&$Art)?"checked":"";?> /> Super fly<br>
						<input type="checkbox" name="Archiving" value="3" <?=(isset($Archiving)&&$Archiving)?"checked":"";?> /> Archiving<br>
						<input type="checkbox" name="Database" value="4" <?=(isset($Database)&&$Database)?"checked":"";?> /> Database<br>
					</div>

					<div class="status_edit">
						<label for="status">Status:</label><br>
						<input type="radio" name="status" value="1" <?=(isset($status)&&$status)?"checked":"";?> /> Publish<br>
						<input type="radio" name="status" value="0" <?=(isset($status)&&!$status)?"checked":"";?> /> Draft<br>
					</div>
					<br><br>
					<?php 
						if (isset($Postid) ):
							echo "<a href='http://dight350.tardis-shoes.com/lestarge/mini-cms/postView.php?id=$Postid' class='btn btn-default'>Cancel</a>";
						else:
							echo "<a href='http://dight350.tardis-shoes.com/lestarge/mini-cms/' class='btn btn-default'>Cancel</a>";
						endif;
					?>
					<input type="submit" name="btn_action" class="btn_action btn btn-default <?=$action;?>" value="<?=$btn_value;?>" />
				</fieldset>
			</form>

		</div>
	<?php endblock(); ?>
</html>