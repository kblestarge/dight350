<?php
	require_once 'class.postInput.php'; # Make sure you have the needed Class file
	require_once 'ti.php';
?><!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

		<link rel="stylesheet" href="styles.css" />

		<title>mini-cms</title>
	</head>
	
	<body>
		<div class="nav_bar col-md-2">

			<h1 class="title1">Kevin's CMS</h1>
			<a href="http://dight350.tardis-shoes.com/lestarge/mini-cms/" class="left_btn btn btn-primary">Home</a><br>

			<div class="dropdown">
			  <button class="left_drop btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="false">
			    Filter by tag
			    <span class="caret"></span>
			  </button>
				  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
				    <form action='postEdit.php' method='post'>
					    <li role="presentation"><input type='submit' name='btn_action' class='btn_action left_btn btn btn-default' value='History'/></li>
					    <li role="presentation"><input type='submit' name='btn_action' class='btn_action left_btn btn btn-default' value='Art'/></li>
					    <li role="presentation"><input type='submit' name='btn_action' class='btn_action left_btn btn btn-default' value='Database'/></li>
					    <li role="presentation"><input type='submit' name='btn_action' class='btn_action left_btn btn btn-default' value='Archiving'/></li>
				    </form>
				  </ul>
			</div>

			<?php
				$myList = new PostListClass;

				if( isset($_GET["filter"]) ):
					$Tag = $_GET["filter"];
					echo "<h4 style='color:white;'>$Tag</h4>";
					switch ($Tag):
						case "History":
							$TagID = 1;
							break;
						case "Art":
							$TagID = 2;
							break;
						case "Database":
							$TagID = 3;
							break;
						case "Archiving":
							$TagID = 4;
							break;
					endswitch;
					$myList->filterTags($TagID);
					echo "<br>";
				else:
					echo "<h4 style='color:white;'>All Posts</h4>";
					$myList->displayPosts();
				endif;
			?>

			<form action='postEdit.php' method='post'>
				<input type='submit' name='btn_action' class='btn_action left_btn btn btn-warning' value='Add Post'/>
			</form>

		</div>	
		<div class="right_content col-md-10">
				<div>
					<?php startblock('content') ?>
					<?php endblock() ?>
				</div>
		</div>
	</body>
</html>