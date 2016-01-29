<?php
	session_start();

	class dj {

		private static $database;

		public function initializeDB() {
			# New mysqli Object for database communication
			self::$database = new mysqli("localhost", "tardissh_kles", "8608!", "tardissh_lestarge");

			# Kill the page is there was a problem with the database connection
			if ( self::$database->connect_error ):
				die( "Connection Error! Error: " . $this->database->connect_error );
			endif;
		}

		static function sightingDisplay() {
		self::initializeDB();

		$query = "
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
		";

		if ( $galleryImages = self::$database->prepare($query) ):
			$galleryImages->execute();
			$galleryImages->store_result();
			$galleryImages->bind_result($id,$type,$growthStage,$name,$day,$time,$obervationNotes);

				if ( $galleryImages->num_rows == 0 ):
					echo "<p class='bg-danger'>No images currently in the gallery.</p>";
				else:
					echo "	
							<table class='table'>
								<tr>
									<th>Sighting ID</th>
									<th>Type</th>
									<th>Growth Stage</th>
									<th>Location</th>
									<th>Day</th>
									<th>Time</th>
									<th>Observation Notes</th>
								</tr>";

					while( $galleryImages->fetch()):
						echo "
								<tr>
									<td>$id</td>
									<td>$type</td>
									<td>$growthStage</td>
									<td>$name</td>
									<td>$day</td>
									<td>$time</td>
									<td>$obervationNotes</td>
								</tr>
						";
					endwhile;

					echo "
							</table>
						";
				endif;
			endif;
		}

		static function mostType() {
		self::initializeDB();

		$query = "
			SELECT
				type, counted
			FROM
			(SELECT
				d.type, count(d.type) as counted
			FROM
				dj_dragloc dl
			JOIN
				dj_dragon d on d.id = dl.dragonID
			GROUP BY
				d.type) rc
			ORDER BY
				counted DESC
			LIMIT 1
		";

		if ( $galleryImages = self::$database->prepare($query) ):
			$galleryImages->execute();
			$galleryImages->store_result();
			$galleryImages->bind_result($type,$counted);

				if ( $galleryImages->num_rows == 0 ):
					echo "<p class='bg-danger'>No images currently in the gallery.</p>";
				else:
					echo "
							<div class='smTable'>
							<h4 class='center_text blu'>Most Sighted Type</h4>
							<table class='table'>
								<tr>
									<th>Type</th>
									<th>Sightings</th>
								</tr>";

					while( $galleryImages->fetch()):
						echo "
								<tr>
									<td>$type</td>
									<td>$counted</td>
								</tr>
						";
					endwhile;

					echo "
							</table>
							</div>
						";
				endif;
			endif;
		}

		static function leaseType() {
		self::initializeDB();

		$query = "
			SELECT
				type, counted
			FROM
			(SELECT
				d.type, count(d.type) as counted
			FROM
				dj_dragloc dl
			JOIN
				dj_dragon d on d.id = dl.dragonID
			GROUP BY
				d.type) rc
			ORDER BY
				counted ASC
			LIMIT 1
		";

		if ( $galleryImages = self::$database->prepare($query) ):
			$galleryImages->execute();
			$galleryImages->store_result();
			$galleryImages->bind_result($type,$counted);

				if ( $galleryImages->num_rows == 0 ):
					echo "<p class='bg-danger'>No images currently in the gallery.</p>";
				else:
					echo "	<div class='smTable'>
							<h4 class='center_text blu'>Least Sighted Type</h4>
							<table class='table'>
								<tr>
									<th>Type</th>
									<th>Sightings</th>
								</tr>";

					while( $galleryImages->fetch()):
						echo "
								<tr>
									<td>$type</td>
									<td>$counted</td>
								</tr>
						";
					endwhile;

					echo "
							</table>
							</div>
						";
				endif;
			endif;
		}

		static function mostGrowthStage() {
		self::initializeDB();

		$query = "
			SELECT
				name, counted
			FROM
			(SELECT
				gs.name, count(gs.name) as counted
			FROM
				dj_dragloc dl
			JOIN
				dj_growthStage gs on gs.id = dl.growthStageID
			GROUP BY
				gs.name) rc
			ORDER BY
				counted DESC
			LIMIT 1
		";

		if ( $galleryImages = self::$database->prepare($query) ):
			$galleryImages->execute();
			$galleryImages->store_result();
			$galleryImages->bind_result($name,$counted);

				if ( $galleryImages->num_rows == 0 ):
					echo "<p class='bg-danger'>No images currently in the gallery.</p>";
				else:
					echo "	<div class='smTable'>
							<h4 class='center_text blu'>Most Sighted Growth Stage</h4>
							<table class='table'>
								<tr>
									<th>Growth Stage</th>
									<th>Sightings</th>
								</tr>";

					while( $galleryImages->fetch()):
						echo "
								<tr>
									<td>$name</td>
									<td>$counted</td>
								</tr>
						";
					endwhile;

					echo "
							</table>
							</div>
						";
				endif;
			endif;
		}

		static function leaseGrowthStage() {
		self::initializeDB();

		$query = "
			SELECT
				name, counted
			FROM
			(SELECT
				gs.name, count(gs.name) as counted
			FROM
				dj_dragloc dl
			JOIN
				dj_growthStage gs on gs.id = dl.growthStageID
			GROUP BY
				gs.name) rc
			ORDER BY
				counted ASC
			LIMIT 1
		";

		if ( $galleryImages = self::$database->prepare($query) ):
			$galleryImages->execute();
			$galleryImages->store_result();
			$galleryImages->bind_result($name,$counted);

				if ( $galleryImages->num_rows == 0 ):
					echo "<p class='bg-danger'>No images currently in the gallery.</p>";
				else:
					echo "	<div class='smTable'>
								<h4 class='center_text blu'>Least Sighted Growth Stage</h4>
								<table class='table'>
									<tr>
										<th>Growth Stage</th>
										<th>Sightings</th>
									</tr>";

					while( $galleryImages->fetch()):
						echo "
									<tr>
										<td>$name</td>
										<td>$counted</td>
									</tr>
						";
					endwhile;

					echo "
								</table>
							</div>
						";
				endif;
			endif;
		}

	}
?>