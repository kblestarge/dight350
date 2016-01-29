<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		
		<link rel="stylesheet" href="calendar_styles.css">
		
		<title>Simple PHP Calendar</title>
	</head>
	
	<body>
		<?php
			require 'calendar_builder.php';
			
			echo calendar_builder();
		?>
	</body>
</html>