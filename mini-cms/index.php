
<?php 
	include("base.php"); 
	require_once 'class.postInput.php';
	startblock('content') ?>

		<h1>Digital Humanities</h1>
		<?php
			# Check for success message trigger and display accordingly
			if( isset($_GET["success"]) ):
				switch($_GET["success"]):
					case "add":
						echo "<p class='bg-success'>post added successfully.</p>";
						break;
						
					case "delete":
						echo "<p class='bg-success'>post removed successfully.</p>";
						break;
						
				endswitch;
			endif;
		?>
		<div class='display_comments'>
<b>How do those two words belong in the same sentence?
And why is it a major/minor in the Humanities department?</b>

	Well, my first thought was that it's just something the Humanities major's can take to put on a resume so they 
can get a job out of college, haha. And I'm sure that is partially the reason, however, there is more to it
than that.
	Digital Humanities is a field of study that utilizes the latest technology to aid art in inspiring the human mind.
Humans are an evolving species that are becoming harder and harder to reach through old art from antiquity.
Digital Humanities provides a modern link from the past to the present in order to bring the art to where that
people are. It's pretty rad stuff :)
		</div>

<?php endblock() ?>