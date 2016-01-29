<?php

	class toDoList {
		# Establish variables for internal-only use
		private $database;
		private $itemsList;
		private $itemInfo;

		# This method is automagically called when you create a new Object using this Class
		public function __construct() {
			# New mysqli Object for database communication
			$this->database = new mysqli("localhost", "tardissh_kles", "8608!", "tardissh_lestarge");

			# Kill the page is there was a problem with the database connection
			if ( $this->database->connect_error ):
				die( "Connection Error! Error: " . $this->database->connect_error );
			endif;
		}

		# Get all the information for a single Item
		public function singleItem($id) {
			$query_singleItem = "
				SELECT 
					id,priority,description,complete
				FROM
					toDo
				WHERE
					id=?
				LIMIT 1
			";
			
			#protects against sql injection
			if ( $Item = $this->database->prepare($query_singleItem) ):
				 $Item->bind_param(
				 	'i',
				 	$id
				 );
				 
				 $Item->execute();
				 
				 $Item->bind_result($id,$priority,$description,$complete);
				 
				 $Item->fetch();
				 
				 $itemInfo["Itemid"] = $id;
 				 $itemInfo["priority"] = $priority;
 				 $itemInfo["description"] = $description;
				 $itemInfo["complete"] = $complete;
				 
				 $Item->close();
				 
				 return $itemInfo;
			endif;
		}
	
		# Get the information for all Items in the database
		public function allItems() {
			# Pre-define our select query
			$query_allItems = "
				SELECT 
					id,priority,description,complete
				FROM
					toDo
				ORDER BY
					priority DESC
			";

			# If the query from above prepares properly, execute it
			# Else, show an error message
			if ( $this->itemsList = $this->database->prepare($query_allItems) ):
				$this->itemsList->execute();
			else:
				die ( "<p class='error'>There was a problem executing your query</p>" );
			endif;
		}
		
		# Take all the Items and display them to the screen
		public function displayItems() {
			$this->allItems();

			# Storing the result gives us access to several specialized properties
			$this->itemsList->store_result();

			# Bind the fields for each returned record to local variables that we name
			$this->itemsList->bind_result($id,$priority,$description,$complete);

			# If the database is empty, show a message accordingly
			if ( $this->itemsList->num_rows == 0 ):
				echo "
					<table>
						<tr>
							<td colspan='6' class='error'>
								<p>No toDo currently found in stock at this time.</p>
							</td>
						</tr>
						<tr>
							<td colspan='6'>
								<form action='toDoManagement.php' method='post'>
									<input type='hidden' name='activity' value='add_item' />

									<input type='submit' name='btn_add' class='btn_action' value='Add an item' />
								</form>
							</td>
						</tr>
					</table>
				"; 
			else:
				# Show all the Items
				echo " 
					<form action='toDoManagement.php' method='post'>

						<div style='margin-bottom: 10px;'>
							<input type='submit' name='btn_action' class='btn_action' value='Add Item' style='margin-right: 40px; margin-left: 10px'/>

							<input type='submit' name='btn_action' class='btn_action edit' value='Edit Item' style='margin-right: 40px;'/>

							<input type='submit' name='btn_action' class='btn_action delete' value='Delete Item' style='margin-right: 5px;'/>
						</div>

						<table id='tableSelect' class='table table-hover rowclick'>
							<thead>
								<tr>
									<th>priority</th>
									<th>description</th>
									<th>complete</th>
									<th scope='Row'>ID</th>
								</tr>
							</thead>
				";

				# Grabbing one Item record at a time display its respective information
				while( $this->itemsList->fetch() ):	
					
					$completed_class = ($complete?"success":"");
					$completed_pic= ($complete?"<img src=\"Checkmark.png\" alt=\"complete\" height=\"24\" width=\"\">":"");
					#$true_false = ($complete?"1":"0");
					#$true_false_switch = ($complete?"0":"1");


					echo "
							<tr class='$completed_class left'>
									<td>$priority</td>
									<td class='centered'>$description</td>
									<td>$completed_pic</td>
									<td><input type='radio' name='Itemid' value='$id' /></td>
							</tr>
						";

				endwhile;

				echo "
						</table>
						
						<input type='submit' name='btn_action' class='btn_action' value='Add Item' style='margin-right: 40px; margin-left: 10px'/>

						<input type='submit' name='btn_action' class='btn_action edit' value='Edit Item' style='margin-right: 40px;'/>

						<input type='submit' name='btn_action' class='btn_action delete' value='Delete Item' style='margin-right: 5px; margin-bottom: 5px;'/>
					</form>
				";

				# Close out the prepared statement
				$this->itemsList->close();
			endif;
		}
		
		public function addItem($priority,$description,$complete) {
			# Template for our insert query
			$insert_query = "
				INSERT INTO
					toDo
					(priority,description,complete)
				VALUES
					(?, ?, ?)
			";

			# If the query prepares properly, send the record in to the database
			if ( $newItem = $this->database->prepare($insert_query) ):
				
				# First argument is the data types for each piece of information
				# Second argument is the data itself
				$newItem->bind_param(
					'isi',
					$priority, $description, $complete
				);
				
				$newItem->execute();
				
				# Close out the prepared statement
				$newItem->close();
				
				# Return the index page, using the GET to supply a message
				header("location: index.php?success=add");
			endif;
		}
		
		# Edit an existing Item
		public function editItem( $id, $priority, $description, $complete ) {
			$update_query = "
				UPDATE
					toDo
				SET
					priority=?,
					description=?,
					complete=?
				WHERE
					id=?
				LIMIT 1
			";
			
			if ( $Item_update = $this->database->prepare($update_query) ):
				$Item_update->bind_param(
					'isii',
					$priority, $description, $complete, $id
				);
				
				$Item_update->execute();
				
				$Item_update->close();
				
				header("location: index.php?success=edit");
			endif;
		}
		
		# Delete an existing Item from the database
		public function removeItem($id) {
			$delete_query = "
				DELETE FROM
					toDo
				WHERE 
					id=?
				LIMIT 1
			";
			
			if ( $ItemRemoval = $this->database->prepare($delete_query) ):
				$ItemRemoval->bind_param(
					'i',
					$id
				);
				
				$ItemRemoval->execute();
				
				$ItemRemoval->close();
				
				header("location: index.php?success=delete");
			endif;
		}
	}
	
	
	
	
	
?>