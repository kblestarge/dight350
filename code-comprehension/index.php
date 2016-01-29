<html>
<head>
	<link rel="stylesheet" href="styles.css" />

	<title>Code-comprehension</title>
</head>
<body>
	<pre class="clean_center">
<a href="/lestarge/code-comprehension/class_php.php">class.php Page &gt;&gt;</a>
<h1 style="text-align: right;">Code Comprehension</h1>
<h2 style="text-align: right;">by Kevin LeStarge</h2>
&lt;?php
<p class='comment'>Connects the class.ElementalStone.php page with this index page, and starts a new session of the index page</p>
	require 'class.ElementalStone.php';
	session_start();
<p class='comment'>if the user selects the reset button, all the session variables will be cleared.</p>
	if (!empty($_POST['reset'])) session_unset();
<p class='comment'>If there is no data in the high_scores session variable, then create a new instance of the class HighScoreTable</p>
	if (!isset($_SESSION['high_scores'])) $_SESSION['high_scores'] = new HighScoreTable;
	
<p class='comment'>Once you've played a round of the game, entered your initials, and clicked submit, the function addToScores passes 
	two parameters: 1) current_game and 2) the player. These two variables are then passed through the function 
	which spits out the data into the Game Summary table</p>
	if (!empty($_POST['submit_player'])) {
		$_SESSION['high_scores']-&gt;addToScores($_SESSION['current_game'],$_POST['player']);	
		unset($_SESSION['current_game']);
	}
<p class='comment'>If there isn't already a current running game, start one. This calls the ElementalGame construct to make a new game 
	object and then stores that into the game variable</p>
	if (!isset($_SESSION['current_game'])) $_SESSION['current_game'] = new ElementalGame;
	$game = $_SESSION['current_game'];
<p class='comment'>Onclick of a potion/power thing, the action function is called which performs a certain action depending on 
what the user has selected. The If statement then checks to see if the turn_count is on turn 2 or 4, if that is true,
then it calls a random action to be performed (aka a random potion or element to change the crystal)</p>
	if (!empty($_POST['action'])) {
		$game-&gt;performAction($_POST['action']);

		if ($game-&gt;getTurn_count() == 2 || $game-&gt;getTurn_count() == 4 ){
			$game-&gt;performAction('random');
		}
	}

?&gt;&lt;!doctype html&gt;
&lt;html&gt;
	&lt;head&gt;
		&lt;meta charset="utf-8" /&gt;

		&lt;link rel="shortcut icon" href="favicon-normal.ico" type="image/x-icon"&gt;
		&lt;link rel="icon" href="favicon-normal.ico" type="image/x-icon"&gt;
		&lt;link href='http://fonts.googleapis.com/css?family=Press+Start+2P' rel='stylesheet' type='text/css'&gt;
		
		&lt;link rel="stylesheet" href="styles.css" /&gt;

		&lt;title&gt;Elemental Stones | Beast Mode&lt;/title&gt;
	&lt;/head&gt;

	&lt;body class="clearfix"&gt;
		&lt;h1&gt;Elemental Stones | Beast Mode&lt;/h1&gt;
		&lt;section class="clearfix"&gt;
			&lt;div id="current_game"&gt;
			<p class='comment'>Calls the displayHistory function which returns the current game's turn by turn outputs.</p>
				&lt;?php echo $game-&gt;displayHistory(); ?&gt;
			&lt;/div&gt;
		&lt;/section&gt;
		&lt;section id="forms"&gt;
		<p class='comment'>If the turn_count is less than 5, keep playing. Else, calculate the score (which is a function
			that calculates the score)</p>
			&lt;?php if ($game-&gt;getTurn_count()&lt;5):?&gt;
				&lt;h4&gt;Select a Magic to Apply&lt;/h4&gt;
				&lt;form name="action_performed" id="action_performed" method="POST" &gt;
					&lt;input type="submit" name="action" id="potion" class="btn_potion button" value="potion"&gt;
					&lt;span class="tooltip"&gt;&lt;span&gt;Potion&lt;/span&gt;Drench the stone with this fantastic growth formula. Caution: If stone gets too large it will break.&lt;/span&gt;
					&lt;input type="submit" name="action" id="red" class="btn_magic button" value="red"&gt;
					&lt;span class="tooltip"&gt;&lt;span&gt;Fire&lt;/span&gt;Cast the blazing fire spell to imbue the stone with redness.&lt;/span&gt;
					&lt;input type="submit" name="action" id="blue" class="btn_magic button" value="blue"&gt;
					&lt;span class="tooltip"&gt;&lt;span&gt;Water&lt;/span&gt;Cast the soothing water spell to imbue the stone with blueness.&lt;/span&gt;
					&lt;input type="submit" name="action" id="yellow" class="btn_magic button" value="yellow"&gt;
					&lt;span class="tooltip"&gt;&lt;span&gt;Lightning&lt;/span&gt;Cast the electrifying lightning spell to imbue the stone with yellowness.&lt;/span&gt;
				&lt;/form&gt;
			&lt;?php else: ?&gt;
				&lt;div id="score"&gt;
					&lt;h2&gt;&lt;?php echo $game-&gt;calculateScore(); ?&gt;&lt;/h2&gt;
				&lt;/div&gt;
				&lt;form name="record_score" id="record_score" method="POST" &gt;
					&lt;input type="text" name="player" id="player" placeholder="Initials" Required maxlength="3" size="3" autofocus="true" autocomplete="off" onkeyup="this.value=this.value.toUpperCase()"&gt;
					&lt;input type="submit" name="submit_player" id="submit_player" value="Submit"&gt;
				&lt;/form&gt;
			&lt;?php endif; ?&gt;
			
		&lt;/section&gt;
		&lt;section class="clearfix"&gt;
			&lt;table class="bordered small" id="possible_scores"&gt;
				&lt;thead&gt;&lt;tr&gt;&lt;td colspan='2'&gt;&lt;h3&gt;Scoring&lt;/h3&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/thead&gt;
				&lt;tr&gt;&lt;th&gt;Stone&lt;/th&gt;&lt;th&gt;Score&lt;/th&gt;
				&lt;tr&gt;&lt;td&gt;&lt;div class="mini stone-1 blue red"&gt;&lt;/div&gt;&lt;/td&gt;&lt;td&gt;600&lt;/td&gt;
				&lt;tr&gt;&lt;td&gt;&lt;div class="mini stone-1 blue yellow"&gt;&lt;/div&gt;&lt;/td&gt;&lt;td&gt;500&lt;/td&gt;
				&lt;tr&gt;&lt;td&gt;&lt;div class="mini stone-1 yellow red"&gt;&lt;/div&gt;&lt;/td&gt;&lt;td&gt;400&lt;/td&gt;
				&lt;tr&gt;&lt;td&gt;&lt;div class="mini stone-1 blue"&gt;&lt;/div&gt;&lt;/td&gt;&lt;td&gt;300&lt;/td&gt;
				&lt;tr&gt;&lt;td&gt;&lt;div class="mini stone-1 yellow"&gt;&lt;/div&gt;&lt;/td&gt;&lt;td&gt;200&lt;/td&gt;
				&lt;tr&gt;&lt;td&gt;&lt;div class="mini stone-1 red"&gt;&lt;/div&gt;&lt;/td&gt;&lt;td&gt;100&lt;/td&gt;
				&lt;tr&gt;&lt;th colspan='2'&gt;Stone Size (1-4) is Multiplier.&lt;/th&gt;&lt;/tr&gt;
			&lt;/table&gt;
			<p class='comment'>After it is calculated, print the high_scores table to the screen.</p>
			&lt;?php
				$_SESSION['high_scores']-&gt;printScores();
			?&gt;
			

		&lt;/section&gt;
		&lt;form name="reset" id="reset" method="POST" &gt;
					&lt;input type="submit" name="reset" id="reset" value="Reset"&gt;
			&lt;/form&gt;

	&lt;/body&gt;
&lt;/html&gt;
<p class='comment'>take all the data from the game variable and put it into current_game variable, which is still blank from 
it's instantiation.</p>
&lt;?php
	$_SESSION['current_game']=$game;
?&gt;
	</pre>
</body>
</html>
