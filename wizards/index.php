<?php require_once 'class.wizardCouncil.php'; ?><!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		
		<link rel="stylesheet" href="council.css" />
		
		<title>Wizard Council</title>
	</head>
	
	<body>
		<h1>Wizard Council</h1>
		<hr>
		<?php
			$wizards = new wizardCouncil;
			$wizards->displayWizards();
			$wizards->displayAlignments();
		?>
	</body>
</html>