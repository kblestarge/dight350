<?php
	require_once 'code-engine.php';
?><!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		
		<link rel="stylesheet" href="styles.css" />

		<title>Potion Shop Inventory</title>
	</head>
	
	<body>
		<h1>Potion Shop Inventory</h1>
		<table border="1">
		<tr>
			<th>Name</th>
			<th>Color</th>
			<th>Intended Effects</th>
			<th>Side Effects</th>
			<th>Quantity</th>
		</tr>
		<?php
			if ( $potions->num_rows == 0 ):
				echo "
					<tr>
						<td colspan='6' class='error'>
							<p>No potions can be found at this time.</p>
							<p>Try adding something to the inventory.</p>
						</td>
					</tr>
				";
			else:
				while( $potions->fetch() ):
					$side_effects_list = explode(",",$side_effects);
					$intended_effects_list = explode(",",$intended_effects);
					$toxicity = ($toxic?"class='toxic'":"");
					
					echo "
						<tr $toxicity>
							<td>$name</td>
							<td>$color</td>
							<td>
								<ul>
							";
							foreach($intended_effects_list as $effect):
								echo "<li>$effect</li>";	
							endforeach;
					echo	"	</ul>
							</td>
							<td>
								<ul>
							";
								foreach($side_effects_list as $effect):
									echo "<li>$effect</li>";	
								endforeach;
					echo "		</ul>
							</td>
							<td>$quantity</td>
						</tr>
					";
				endwhile;

				echo "
						<tr>
							<td colspan='6' class='error'>
								<form action='store-room.php' method='post'>
									<input type='hidden' name='activity' value='add_potion' />

									<input type='submit' name='btn_add' value='Add a Potion' />
								</form>
							</td>
						</tr>
				";
			endif;
		?>
		</table>
	</body>
</html>