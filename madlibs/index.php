<!DOCTYPE html>
<html>
	<head>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
		<style>
			.center {
			    margin-left: auto;
			    margin-right: auto;
			}
			h1 {
				color:white;
				margin-bottom:5px;
			}
			h3 {
				color:#553821;
			}
			p    {
				color:white
			}
			.plainbox {
				margin-left: auto;
				padding: 20px;
				margin-right: auto;
			    border: 2px solid;
			    border-radius: 25px;
			    border-color:#553821;
			    width:600px;
			    margin-bottom:10px;
			}
			.whitebox{
				margin-left: auto;
				padding: 20px;
				margin-right: auto;
			    border-radius: 25px;
			    background-color:white; 
			    width:500px;
			    margin-bottom:10px;
			}
			h4{
				color:#c5ad9a;
			}
		</style>
	</head>

<body>

	<div align="center">
	<h1>Madlib</h1>
	<h3>by Kevin LeStarge</h3>
	</div>

<form class="form-inline" action="index.php" method="post">
	<div align="center">
	  <div class="form-group">
	    <input type="text" class="form-control" style="width: 300px; margin-bottom:5px;" name="noun" placeholder="Noun, noun, noun, etc." >
	  </div>
	  <br>
	  <div class="form-group">
	    <input type="text" class="form-control" style="width: 300px; margin-bottom:5px;" name="adjective" placeholder="Adjective, adjective, adjective, etc." >
	  </div>
	  <br>
	  <div class="form-group">
	    <input type="text" class="form-control" style="width: 300px; margin-bottom:5px;" name="adverb" placeholder="Adverb, adverb, adverb, etc." >
	  </div>
	  <br>
	  <div class="form-group">
	    <input type="text" class="form-control" style="width: 300px; margin-bottom:5px;" name="verb" placeholder="Verb, verb, verb, etc." >
	  </div>
	  <br>
	    <div class="form-group">
	    <input type="text" class="form-control" style="width: 300px; margin-bottom:5px;" name="verbing" placeholder="Verb ending in -ing" >
	  </div>

	  		<h3>Choose your story:</h3>
			<div align="center">
			  <form role="form">
			    <label class="checkbox-inline" style="color:#c5ad9a; font-size:120%;">
			      <input type="checkbox" name="Bobby">Bobby's story
			    </label>
			    <label class="checkbox-inline" style="color:#c5ad9a; font-size:120%;">
			      <input type="checkbox" name="Techdeck">Techdeck story
			    </label>
			    <label class="checkbox-inline" style="color:#c5ad9a; font-size:120%;">
			      <input type="checkbox" name="Ninja">Magical Ninja story
			    </label>
			  </form>
			</div>

	  <br>
	  <button type="submit" class="btn btn-default" >Madlib it up!</button>
	  <br><br><br>
  </div>
</form>

	<html>
	<head>

	</head>
		<body background="background.jpg">

			<?php 

				$noun = $_POST["noun"];
				$adjective = $_POST["adjective"];
				$adverb = $_POST["adverb"];
				$verb = $_POST["verb"];
				$verbing = $_POST["verbing"];

				$myNouns = array('Helicopter','Obamacare','James Bond','yo mama','convent','Madagascar','Steven Dewey','mens restroom');
				$myAdjectives = array('stanky','super fly','dope','cool','naste','ridiculous','sick','gnarly');
				$myAdverbs = array('quickly','wearily','truthfully','beautifully','endlessly','weirdly','wickedly','brutally');
				$myVerbs = array('run','fly','smell','camp','squat','pump','bust','eat','steal','walk','jump');
				$myVerbings = array('pumping','jumping','jamming','filling','chilling');
				

				#How do I tell it not to count NULL in theirNoun array?
				shuffle($myNouns);
				$theirNouns = explode(', ',$noun);
				if($theirNouns[0] == ''){
					$finalNouns = $myNouns;
				}
				else{
					shuffle($theirNouns);
					$finalNouns = array_merge($theirNouns, $myNouns);
				}

				shuffle($myAdjectives);
				$theirAdjectives = explode(', ',$adjective);
				if($theirAdjectives[0] == ''){
					$finalAdjectives = $myAdjectives;
				}
				else{
					shuffle($theirAdjectives);
					$finalAdjectives = array_merge($theirAdjectives, $myAdjectives);
				}

				shuffle($myAdverbs);
				$theirAdverbs = explode(', ',$adverb);
				if($theirAdverbs[0] == ''){
					$finalAdverbs = $myAdverbs;
				}
				else{
					shuffle($theirAdverbs);
					$finalAdverbs = array_merge($theirAdverbs, $myAdverbs);
				}

				shuffle($myVerbs);
				$theirVerbs = explode(', ',$verb);
				if($theirVerbs[0] == ''){
					$finalVerbs = $myVerbs;
				}
				else{
					shuffle($theirVerbs);
					$finalVerbs = array_merge($theirVerbs, $myVerbs);
				}

				shuffle($myVerbings);
				$theirVerbings= explode(', ',$verbing);
				if($theirVerbings[0] == ''){
					$finalVerbings = $myVerbings;
				}
				else{
					shuffle($theirVerbings);
					$finalVerbings = array_merge($theirVerbings, $myVerbings);
				}
				#$XmyNouns = explode(',',$myNouns);
				#echo $XmyNouns[1];

				#$random_keys=array_rand($XmyNouns,3);
				#echo $XmyNouns[$random_keys[0]]."<br>";
				#echo $XmyNouns[$random_keys[1]]."<br>";
				#echo $XmyNouns[$random_keys[2]]."<br>";
				#var_dump($finalNouns);

				if(isset($_POST['Bobby'])){
				#Bobby's story
					echo "<div class=\"plainbox\">
					<h4>Bobby's Story</h4>";
					echo "<p>One ".$finalAdjectives[0]." day, Bobby was ".$finalVerbings[0]." around the ".$finalNouns[0].", when ".$finalAdverbs[0].", Bobby saw his aquaintence, ".$finalNouns[1].". 
					\"Hey,\" said Bobby, \"Wanna ".$finalVerbs[0]." out of here and ".$finalVerbs[1]." that ".$finalNouns[2]." over there?\" The two friends ".$finalAdverbs[1]." became ".$finalAdjectives[1]." friends. The end.</p></div>";
				}

				if(isset($_POST['Techdeck'])){
					echo "<div class=\"plainbox\">
					<h4>Techdeck Story</h4>";
					echo "<p>Teckdecks are ".$finalAdjectives[0].". Everyone in the whole ".$finalAdjectives[1]." world should ".$finalVerbs[0]." one. Techdecks can ".$finalVerbs[1]." over ".$finalNouns[0]."s. 
					Their wheels ".$finalAdverb[0]." ".$finalVerbs[2]." when you do a trick right. Sometimes it's fun to try finding new ".$finalAdjectives[2]." places to skate on, like ".$finalNouns[1]."s and ".$finalNouns[2]."s. The end.</p></div>";
				}

				if(isset($_POST['Ninja'])){
					echo "<div class=\"plainbox\">
					<h4>Magical Ninja Story</h4>";
					echo "<p>Once upon a ".$finalAdjectives[0]." time, there lived a magical ninja who came from the ".$finalAdjectives[1]." land of ".$finalNouns[0]."s. He liked to ".$finalVerbs[0]." ".$finalAdverbs[0].", and it just so happened that the
					King of the land was announcing a ".$finalVerbings[0]." competition, which he thought was similar enough. And so, the ninja went to ".$finalNouns[1]." and asked if he could ".$finalVerbs[1]." the competition. \"Sorry,\" said the ".$finalAdjectives[2]."
					 manager in charge, \"you have to be able to ".$finalAdverbs[1]." ".$finalVerbs[2]." at least three miles in order to sign up\". The ninja thought that was a dumb prerequisite, so he didn't sign up, but instead began to ".$finalVerbs[3]." ".$finalAdjectives[0]." ".$finalNouns[2]."s. The end.</p>";
				}
				
			?>

		</body>
	</html>
</body>
</html>