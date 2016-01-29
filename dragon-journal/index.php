 <?php 
	require 'class.dj.php';
	$dj = new dj;
	session_start();
?><!DOCTYPE html>
<html>
	<head>
		<title>Dragon Journal</title>
		<link rel="icon" type="image/png" href="http://www.obsidianportal.com/favicon.ico">
		<link rel="stylesheet" type="text/css" href="styles.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	</head>
	<body class='main'>

		<h1 class="center_text">Dragon Journal</h1>

		<hr color="black" size="3" width="100%">

		<h2 class='center_text blu'>Database Table Structure</h2>
		<br>

		<div class="row">
		  <div class="col-md-3">
	  		<div class="diagram hvr-wobble-top">
	  			<h4 class="dHead">dj_dragon</h4>
	  			<p class="dragID">id</p>
	  			<p>type</p>
  			</div>
		  </div>
		  	<div class="col-md-3">
	  			<div class="diagram hvr-wobble-skew ">
	  			<h4 class="dHead">dj_dragloc</h4>
	  			<p>id</p>
	  			<p class="dragID">*dragonID</p>
	  			<p class="gsID">*growthStageID</p>
	  			<p class="locID">*locationID</p>
	  			<p>day</p>
	  			<p>time</p>
	  			<p>observationNotes</p>
	  			<hr color="black" size="2" width="100%">
	  			<p>*Foreign key: linked to identically colored id</p>
  			</div>
		  </div>
		  <div class="col-md-3">
	  		<div class="diagram hvr-wobble-top">
	  			<h4 class="dHead">dj_growthStage</h4>
	  			<p class="gsID">id</p>
	  			<p>name</p>
  			</div>
		  </div>
		  <div class="col-md-3">
	  		<div class="diagram hvr-wobble-top">
	  			<h4 class="dHead">dj_location</h4>
	  			<p class="locID">id</p>
	  			<p>name</p>
  			</div>
		  </div>
		</div>


		<br>
		<hr color="black" size="2" width="50%">


		<h2 class='center_text blu'>Database Queries</h2>

		<div class="row">
			<div class="col-md-6">

				<h3 class='center_text blu'>Add Query</h3>
				<pre>
INSERT INTO
	dj_dragloc
	(dragonID,growthStageID,locationID,day,time,obervationNotes)
VALUES
	(1, 5, 2, "2015-04-01", "21:55", "This is a cool dragon")
				</pre>

				<h3 class='center_text blu'>Update Query</h3>
				<pre>
UPDATE
	dj_dragloc
SET
	dragonID=1,
	growthStageID=1,
	locationID=1,
    	day="2015-01-01",
    	time="12:00",
	obervationNotes="Not a cool dragon"
WHERE
	id=10
LIMIT 1
				</pre>
			</div>


			<div class="col-md-6">

				<h3 class='center_text blu'>Read-out Query</h3>
				<pre>
SELECT
	dl.id, d.type, gs.name, l.name, day, time, obervationNotes
FROM
	dj_dragloc dl
JOIN
	dj_location l on l.id = dl.locationID
JOIN
	dj_dragon d on d.id = dl.dragonID
JOIN
	dj_growthStage gs on gs.id = dl.growthStageID
ORDER BY
	dl.id ASC
				</pre>
				
				<h3 class='center_text blu'>Delete Query</h3>
				<pre>
DELETE FROM
	dj_dragloc
WHERE 
	id=11
LIMIT 1
				</pre>

			</div>
		</div>

		<br>
		<hr color="black" size="2" width="50%">
		<div>
			<?php
				$dj->mostType();
				$dj->leaseType();
				$dj->mostGrowthStage();
				$dj->leaseGrowthStage();
				echo "<h2 class='center_text blu'>Dragon Sightings</h2>";
				$dj->sightingDisplay(); # Call the method through the new Object
			?>
			<br><br><br>
		</div>

	</body>
</html>