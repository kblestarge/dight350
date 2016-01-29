<?php

	class PostListClass {
		# Establish variables for internal-only use
		private $database;
		private $PostList;
		private $PostInfo;

		# This method is automagically called when you create a new Object using this Class
		public function __construct() {
			# New mysqli Object for database communication
			$this->database = new mysqli("localhost", "tardissh_kles", "8608!", "tardissh_lestarge");

			# Kill the page is there was a problem with the database connection
			if ( $this->database->connect_error ):
				die( "Connection Error! Error: " . $this->database->connect_error );
			endif;
		}

		# Get all the information for a single Post ------NEEDS WORK, add tags
		public function singlePost($id) {
			$query_singlePost = "
				SELECT 
					p.id,
					link,
					commentary,
					title,
					status,
					GROUP_CONCAT(DISTINCT tag SEPARATOR ', ' ) AS allTags
				FROM
					Posts p
					JOIN
						Post_Tag pt on p.id=pt.PostID
					JOIN
						Tags t on t.id=pt.TagID
				WHERE
					p.id=?
			";
			
			#protects against sql injection
			if ( $Post = $this->database->prepare($query_singlePost) ):
				 $Post->bind_param(
				 	'i',
				 	$id
				 );
				 
				 $Post->execute();
				 
				 $Post->bind_result($id,$link,$commentary,$title,$status,$allTags);
				 
				 $Post->fetch();
				 
				 $PostInfo["Postid"] = $id;
 				 $PostInfo["link"] = $link;
 				 $PostInfo["commentary"] = $commentary;
				 $PostInfo["title"] = $title;
				 $PostInfo["status"] = $status;
				 $PostInfo["allTags"] = $allTags;
				 
				 $Post->close();
				 
				 return $PostInfo;
			endif;
		}
	
		# Get the information for all Items in the database
		public function allPosts() {
			# Pre-define our select query
			$query_allPosts = "
				SELECT 
					id,title
				FROM
					Posts
				ORDER BY
					id DESC
			";

			# If the query from above prepares properly, execute it
			# Else, show an error message
			if ( $this->PostList = $this->database->prepare($query_allPosts) ):
				$this->PostList->execute();
			else:
				die ( "<p class='error'>There was a problem executing your query</p>" );
			endif;
		}
		
		# Take all the Items and display them to the screen
		public function displayPosts() {
			$this->allPosts();

			# Storing the result gives us access to several specialized properties
			$this->PostList->store_result();

			# Bind the fields for each returned record to local variables that we name
			$this->PostList->bind_result($id,$title);

			# If the database is empty, show a message accordingly
			if ( $this->PostList->num_rows == 0 ):
				echo "
					<p>No Posts currently found in stock at this time.</p>
				"; 
			else:
				# Show all the Items
				# Grabbing one Item record at a time display its respective information
				while( $this->PostList->fetch() ):	
			
							// <td><input type='radio' name='id' value='$id' /></td>
							// <td>$title</td>

					echo "
							<a href='http://dight350.tardis-shoes.com/lestarge/mini-cms/postView.php?id=$id' class='left_btn btn btn-default'>$title</a><br>
						";

				endwhile;

				# Close out the prepared statement
				$this->PostList->close();
			endif;
		}

		# Take all the Items and display them to the screen
		public function filterTags($Tagid) {
			$query_filterPosts = "
				SELECT 
					title, PostID, TagID
				FROM
					Post_Tag pt
					JOIN
						Posts p on p.id=pt.PostID
				WHERE
					TagID=?
			";

			#protects against sql injection
			if ( $this->Post = $this->database->prepare($query_filterPosts) ):
				 $this->Post->bind_param(
				 	'i',
				 	$Tagid
				 );
				 
				 $this->Post->execute();
				 $this->Post->store_result();

				 $this->Post->bind_result($title,$PostID,$TagID);
			else:
				die ( "<p>There was a problem executing your query</p>" );
			endif;
			
			# If the database is empty, show a message accordingly
			if ( $this->Post->num_rows == 0 ):
				
				echo "
					<p>No Posts currently found in stock at this time.</p>
				";
				header("location: index.php");
				
			else:
				while( $this->Post->fetch() ):	
					echo "
							<a href='http://dight350.tardis-shoes.com/lestarge/mini-cms/postView.php?id=$PostID' class='left_btn btn btn-default'>$title</a><br>
						";
				endwhile;

				# Close out the prepared statement
				$this->Post->close();
			endif;
		}
		
		public function maxPostid() {
			$query_max = "
				SELECT 
					max(id) as max
				FROM
					Posts
			";
			
			if ( $this->maxPost = $this->database->prepare($query_max) ):
				$this->maxPost->execute();
			else:
				die ( "<p class='error'>There was a problem executing your query</p>" );
			endif;

			$this->maxPost->store_result();

			$this->maxPost->bind_result($max);

			$this->maxPost->fetch();

			$maxid = $max;

			$this->maxPost->close();

			return $maxid;
		}

		public function addPost($commentary, $title, $status, $link, $PostID, $TagExArray) {
			# Template for our insert query
			$post_query = "
				INSERT INTO
					Posts
					(commentary, title, status, link)
				VALUES
					(?, ?, ?, ?);
			";

			# If the query prepares properly, send the record in to the database
			if ( $newPost = $this->database->prepare($post_query) ):
				
				$newPost->bind_param(
					'ssis',
					$commentary, $title, $status, $link
				);
				
				$newPost->execute();
				
				$newPost->close();
				
				#header("location: index.php?success=add");
			endif;

			foreach ( $TagExArray as &$value ):
				$post_tag_query = "
				INSERT INTO
					Post_Tag
					(PostID, TagID)
				VALUES
					(?, ?);
				";

				if ( $newPost2 = $this->database->prepare($post_tag_query) ):
					
					$newPost2->bind_param(
						'ii',
						$PostID, $value
					);
					
					$newPost2->execute();
					
					$newPost2->close();
				endif;
			endforeach;
			
			header("location: index.php?success=add");
		}
		
		# Edit an existing Item
		public function editPost( $Postid, $commentary, $title, $status, $link, $TagExArray, $Postid2 ) {
			$update_query = "
				UPDATE
					Posts
				SET
					commentary=?,
					title=?,
					status=?,
					link=?
				WHERE
					id=?
				LIMIT 1
			";
			
			if ( $Post_update = $this->database->prepare($update_query) ):
				$Post_update->bind_param(
					'ssisi',
					$commentary, $title, $status, $link, $Postid
				);
				
				$Post_update->execute();
				
				$Post_update->close();
				
			endif;

			$delete_query = "
				DELETE FROM
					Post_Tag
				WHERE 
					PostID=?
			";
			
			if ( $PostRemoval = $this->database->prepare($delete_query) ):
				$PostRemoval->bind_param(
					'i',
					$Postid
				);
				
				$PostRemoval->execute();
				
				$PostRemoval->close();

				#$this->insertTags($Postid2, $TagExArray);
			endif;

			foreach ( $TagExArray as &$value ):
				$post_tag_query2 = "
					INSERT INTO
						Post_Tag
						(PostID, TagID)
					VALUES
						(?, ?);
				";

				if ( $newPost2 = $this->database->prepare($post_tag_query2) ):
					
					$newPost2->bind_param(
						'ii',
						$Postid2, $value
					);
					
					$newPost2->execute();
					
					$newPost2->close();
					
				endif;
			endforeach;
			header("location: postView.php?id=$Postid&success=edit");
		}
		
		# Delete an existing Item from the database
		public function removeItem($id) {
			$delete_query = "
				DELETE FROM
					Posts
				WHERE 
					id=?
				LIMIT 1
			";
			
			if ( $PostRemoval = $this->database->prepare($delete_query) ):
				$PostRemoval->bind_param(
					'i',
					$id
				);
				
				$PostRemoval->execute();
				
				$PostRemoval->close();
				
				header("location: index.php?success=delete");
			endif;
		}
	}
	
	
	
	
	
?>