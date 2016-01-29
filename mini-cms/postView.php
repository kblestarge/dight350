
	<?php
		include("base.php"); 
		require_once 'class.postInput.php';
		
		startblock('content');
			$myList = new PostListClass;

			# Check for post message trigger and display accordingly
			if( isset($_GET["id"]) ):

				$id = $_GET["id"];

				$postDeets = $myList->singlePost($id);

				foreach( $postDeets as $key => $value ):
					${$key} = $value;
				endforeach;

				if( $status):
					$status_word = "Published";
					$boot = "label label-success";
				else:
					$status_word = "Draft";
					$boot = "label label-default";
				endif;

				echo "
				<h1>$title</h1>
				";

				if( isset($_GET["success"]) ):	
					echo "<p class='bg-success'>post updated successfully.</p>";
				endif;

				echo "
				<p class='$boot'>$status_word</p>

				<a href='$link'>
					<h3>$link</h3>
				</a>

				<div class='display_comments'>$commentary</div><br>

				<h3>Tags:</h3>
				<h4>$allTags</h4>
				<br>
				<form action='postEdit.php' method='post'>
					<input type='hidden' name='id' value='$id' />
					<input type='submit' name='btn_action' class='bottom_btn btn btn-default' value='Edit'/>
					<input type='submit' name='btn_action' class='bottom_btn btn btn-default' value='Remove Post'/>
				</form>
				";

			else:
				echo "<p>Dangit, you do not have an ID.</p>";
			endif;
		endblock();

	?>