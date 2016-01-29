<?php
	class PotionShop {
		# Establish variables for internal-only use
		private $database;
		private $potionsList;
		private $potionInfo;

		# This method is automagically called when you create a new Object using this Class
		public function __construct() {
			# New mysqli Object for database communication
			$this->database = new mysqli("localhost", "tardissh_kles", "8608!", "tardissh_lestarge");

			# Kill the page is there was a problem with the database connection
			if ( $this->database->connect_error ):
				die( "Connection Error! Error: " . $this->database->connect_error );
			endif;
		}

		# Get all the information for a single potion
		public function singlePotion($id) {
			$query_singlePotion = "
				SELECT 
					id,name,color,toxic,quantity,intended_effects,side_effects
				FROM
					Potions
				WHERE
					id=?
				LIMIT 1
			";
			
			if ( $potion = $this->database->prepare($query_singlePotion) ):
				 $potion->bind_param(
				 	'i',
				 	$id
				 );
				 
				 $potion->execute();
				 
				 $potion->bind_result($potion_id,$name,$color,$toxic,$quantity,$intended_effects,$side_effects);
				 
				 $potion->fetch();
				 
				 $potionInfo["potion_id"] = $potion_id;
 				 $potionInfo["potion_name"] = $name;
 				 $potionInfo["potion_color"] = $color;
				 $potionInfo["toxic"] = $toxic;
				 $potionInfo["quantity"] = $quantity;
				 $potionInfo["intended_effects"] = $intended_effects;
				 $potionInfo["side_effects"] = $side_effects;
				 
				 $potion->close();
				 
				 return $potionInfo;
			endif;
		}
	
		# Get the information for all potions in the database
		public function allPotions() {
			# Pre-define our select query
			$query_allPotions = "
				SELECT 
					id,name,color,toxic,quantity,intended_effects,side_effects
				FROM
					Potions
				ORDER BY
					quantity DESC
			";

			# If the query from above prepares properly, execute it
			# Else, show an error message
			if ( $this->potionsList = $this->database->prepare($query_allPotions) ):
				$this->potionsList->execute();
			else:
				die ( "<p class='error'>There was a problem executing your query</p>" );
			endif;
		}
		
		# Take all the potions and display them to the screen
		public function displayPotions() {
			$this->allPotions();

			# Storing the result gives us access to several specialized properties
			$this->potionsList->store_result();

			# Bind the fields for each returned record to local variables that we name
			$this->potionsList->bind_result($id,$name,$color,$toxic,$quantity,$intended_effects,$side_effects);

			# If the database is empty, show a message accordingly
			if ( $this->potionsList->num_rows == 0 ):
				echo "
					<table>
						<tr>
							<td colspan='6' class='error'>
								<p>No potions currently found in stock at this time.</p>
							</td>
						</tr>
						<tr>
							<td colspan='6'>
								<form action='store-room.php' method='post'>
									<input type='hidden' name='activity' value='add_potion' />

									<input type='submit' name='btn_add' class='btn_action' value='Add a Potion' />
								</form>
							</td>
						</tr>
					</table>
				";
			else:
				# Show all the potions
				echo "
					<form action='store-room.php' method='post'>
					<table>
						<tr>
							<td colspan='6'>
								
									<input type='submit' name='btn_action' class='btn_action' value='Add Potion' />

									<input type='submit' name='btn_action' class='btn_action edit' value='Edit Potion' />

									<input type='submit' name='btn_action' class='btn_action delete' value='Delete Potion' />
							</td>
						</tr>
						<tr>
							<th>Name</th>
							<th>Color</th>
							<th>Intended Effects</th>
							<th>Side Effects</th>
							<th>Quantity</th>
							<th></th>
						</tr>
				";

				# Grabbing one potion record at a time display its respective information
				while( $this->potionsList->fetch() ):
					# Turn both comma separated lists into arrays
					$intended_effects_list = explode(",",$intended_effects);
					$side_effects_list = explode(",",$side_effects);
					
					# Setup a string to add a class to matching results
					$toxicity = ($toxic?"class='toxic'":"");
					
					echo "
						<tr $toxicity>
							<td>$name</td>
							<td class='centered'>$color</td>
							<td>
								<ul>
							";
							# Echo out each item from the array
							foreach($intended_effects_list as $effect):
								echo "<li>$effect</li>";	
							endforeach;
					echo	"	</ul>
							</td>
							<td>
								<ul>
							";
							# Echo out each item from the array
							foreach($side_effects_list as $effect):
								echo "<li>$effect</li>";	
							endforeach;
					echo "		</ul>
							</td>
							<td class='centered'>$quantity</td>
							<td><input type='radio' name='potion_id' value='$id' /></td>
						</tr>
					";
				endwhile;

				echo "
						<tr>
							<td colspan='6'>
								
									<input type='submit' name='btn_action' class='btn_action' value='Add Potion' />

									<input type='submit' name='btn_action' class='btn_action edit' value='Edit Potion' />

									<input type='submit' name='btn_action' class='btn_action delete' value='Delete Potion' />
							</td>
						</tr>
					</table>
					</form>
				";

				# Close out the prepared statement
				$this->potionsList->close();
			endif;
		}
		
		public function addPotion($name, $color, $toxic, $quantity, $intended_effects, $side_effects) {
			# Template for our insert query
			$insert_query = "
				INSERT INTO
					Potions
					(name, color, toxic, quantity, intended_effects, side_effects)
				VALUES
					(?, ?, ?, ?, ?, ?)
			";

			# If the query prepares properly, send the record in to the database
			if ( $newPotion = $this->database->prepare($insert_query) ):
				
				# First argument is the data types for each piece of information
				# Second argument is the data itself
				$newPotion->bind_param(
					'ssiiss',
					$name, $color, $toxic, $quantity, $intended_effects, $side_effects
				);
				
				$newPotion->execute();
				
				# Close out the prepared statement
				$newPotion->close();
				
				# Return the index page, using the GET to supply a message
				header("location: index.php?success=add");
			endif;
		}
		
		# Edit an existing potion
		public function editPotion( $id, $name, $color, $toxic, $quantity, $intended_effects, $side_effects ) {
			$update_query = "
				UPDATE
					Potions
				SET
					name=?,
					color=?,
					toxic=?,
					quantity=?,
					intended_effects=?,
					side_effects=?
				WHERE
					id=?
				LIMIT 1
			";
			
			if ( $potion_update = $this->database->prepare($update_query) ):
				$potion_update->bind_param(
					'ssiissi',
					$name, $color, $toxic, $quantity, $intended_effects, $side_effects, $id
				);
				
				$potion_update->execute();
				
				$potion_update->close();
				
				header("location: index.php?success=edit");
			endif;
		}
		
		# Delete an existing potion from the database
		public function removePotion($id) {
			$delete_query = "
				DELETE FROM
					Potions
				WHERE 
					id=?
				LIMIT 1
			";
			
			if ( $potionRemoval = $this->database->prepare($delete_query) ):
				$potionRemoval->bind_param(
					'i',
					$id
				);
				
				$potionRemoval->execute();
				
				$potionRemoval->close();
				
				header("location: index.php?success=delete");
			endif;
		}
	}
	
	
	
	
	
?>