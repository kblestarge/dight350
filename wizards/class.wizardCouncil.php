<?php
	class WizardCouncil {
		private $database;
		private $wizardsList;
		private $alignmentsList;

		public function __construct() {
			$this->database = new mysqli("localhost","tardissh_kles","8608!","tardissh_lestarge");

			if ( $this->database->connect_error ):
				die( "Connection Error! Error: " . $this->database->connect_error );
			endif;
		}
		
		public function allWizards() {
			$query_allWizards = "
				SELECT 
					wizards.name,
					alignmets.alignment,
					GROUP_CONCAT(DISTINCT specialty.specialty ORDER BY specialty.specialty SEPARATOR ', ' ) AS Specialty  
				FROM
					wizards
					LEFT JOIN 
						alignmets 
							ON wizards.alignmentID = alignmets.id
					LEFT JOIN 
						wizard_specialty 
							ON wizard_specialty.wizardID = wizards.id
					LEFT JOIN 
						specialty
							ON wizard_specialty.specialtyID = specialty.id
				GROUP BY
					wizards.name
				
			";

			if ( $this->wizardsList = $this->database->prepare($query_allWizards) ):
				$this->wizardsList->execute();
			else:
				die ( "<p class='error'>There was a problem executing your query</p>" );
			endif;
		}

		public function allAlignments() {
			$query_allAlignments = "
				SELECT 
					*
				FROM
					alignmets
			";

			if ( $this->AlignmentsList = $this->database->prepare($query_allAlignments) ):
				$this->AlignmentsList->execute();
			else:
				die ( "<p class='error'>There was a problem executing your query</p>" );
			endif;
		}
		
		public function displayWizards() {
			$this->allWizards();

			$this->wizardsList->store_result();

			$this->wizardsList->bind_result($name,$alignment,$speciality);

			if ( $this->wizardsList->num_rows == 0 ):
				echo "
					<table>
						<tr>
							<td>No Wizards are on the council at this time</td>
						</tr>
					</table>
				";
			else:
				echo "
					<table>
						<tr>
							<th>Name</th>
							<th>Alignment</th>
							<th>Speciality</th>
						</tr>
				";

				while( $this->wizardsList->fetch() ):
					echo "
						<tr>
							<td>$name</td>
							<td>$alignment</td>
							<td>$speciality</td>
						</tr>
					";
				endwhile;

				echo "
					</table>
				";

				$this->wizardsList->close();
			endif;
		}

		public function displayAlignments() {
			$this->allAlignments();

			$this->AlignmentsList->store_result();

			$this->AlignmentsList->bind_result($id,$alignment);

			if ( $this->AlignmentsList->num_rows == 0 ):
				echo "
					<table>
						<tr>
							<td>No Alignments are on the council at this time</td>
						</tr>
					</table>
				";
			else:
				echo "
					<table>
						<tr>
							<th>ID</th>
							<th>Alignment</th>
						</tr>
				";

				while( $this->AlignmentsList->fetch() ):
					echo "
						<tr>
							<td>$id</td>
							<td>$alignment</td>
						</tr>
					";
				endwhile;

				echo "
					</table>
				";

				$this->AlignmentsList->close();
			endif;
		}
	}
?>