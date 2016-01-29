<html>
<head>
	<link rel="stylesheet" href="styles.css" />
	<title></title>
</head>
<body>
	
	<pre class="clean_center">
<a href="/lestarge/code-comprehension/">&lt;&lt; index page</a>
<h1 style="text-align: right;">Code Comprehension</h1>
<h2 style="text-align: right;">by Kevin LeStarge</h2>
<p class='comment'>Defining class of ElementalStone (basically a blueprint of a ElementalStone object). Each object 
of this type will have three private variables with the scope of only this class.</p>
&lt;?php
class ElementalStone {
	private $size;
	private $color=array("","");
	private $valid_colors=array("red","yellow","blue");
<p class='comment'>This is the function that is called to instantiate a new ElementalStone object. It assigns the object 
	a random size between 1 and 4, and a color from the valid_colors array.</p>
	public function __construct() {
		$this-&gt;size = rand(1,4);
		$this-&gt;color = array($this-&gt;valid_colors[array_rand($this-&gt;valid_colors)],$this-&gt;valid_colors[array_rand($this-&gt;valid_colors)]);
	}
<p class='comment'>Return size of object</p>
	public function getSize() {
		return $this-&gt;size;
	}
<p class='comment'>Set the size, if it's greater than 4, turn it into size 1.</p>
	public function setSize($new_size) {
		$this-&gt;size = $new_size;
		if ($this-&gt;size &gt; 4) $this-&gt;size = 1;
	}
<p class='comment'>If the requested data type is a string, implode the color array to be a string 
	separated by a space. If it wants an array, just send the array.</p>
	public function getColor($datatype='array') {
		if ($datatype == "str") return implode(" ", $this-&gt;color);
		return $this-&gt;color;
	}
<p class='comment'>Takes whatever the new color is and puts it at the beginning of the array. Then, 
	if the count of color variables is greater than 2, pop the last one out.</p>
	public function setColor($new_color) {
		array_unshift($this-&gt;color,$new_color);
		if (count($this-&gt;color)&gt;2) array_pop($this-&gt;color);
	}
	
	
}
<p class='comment'>Defining class of ElementalGame (basically a blueprint of a ElementalGame object). Each object 
of this type will have three private variables with the scope of only this class.</p>
class ElementalGame {
	private $stone;
	private $turn_count;
	private $score;
	private $history=array();
<p class='comment'>Used to instanciate a new ElementalGame object</p>
	public function __construct() {
		$this-&gt;stone = new ElementalStone;
		$this-&gt;score = 0;
		$this-&gt;turn_count=0;
		$this-&gt;addToHistory("stone-".$this-&gt;stone-&gt;getSize(), $this-&gt;stone-&gt;getColor("str"));
	}
<p class='comment'>Get's score</p>
	public function getScore() {
		return $this-&gt;score;
	}
<p class='comment'>Set the score based on the parameter passed</p>
	public function setScore($score) {
		$this-&gt;score = $score;
	}	
<p class='comment'>Return the turn count</p>
	public function getTurn_count() {
		return $this-&gt;turn_count;
	}
<p class='comment'>Return the history</p>
	public function getHistory() {
		return $this-&gt;history;
	}
<p class='comment'>Add to the history array</p>
	public function addToHistory($type, $value) {
		array_push($this-&gt;history, $type." ".$value);
	}
<p class='comment'>If the action is not random, then hman is assigned to agent. 
	If action is random, agent is the computer now, and auto assigns the action based on the random switch choice.</p>
	public function performAction($action){
		$agent = " human";
		if ($action=="random") {
			$r = rand(0,3);
			switch ($r):
				case 0:
					$action="potion";
					break;
				case 1:
					$action="red";
					break;
				case 2:
					$action="blue";
					break;
				case 3:
					$action="yellow";
					break;
			endswitch;
			$agent=" computer";
		}
	<p class='comment'>This happens whether or not the agent is a computer or a human. Potion gets bigger,
	 and the elements change the color.</p>
		switch ($action):
			case "potion":
					$size=$this-&gt;stone-&gt;getSize();
					$size++;
					$this-&gt;stone-&gt;setSize($size);
					$this-&gt;addToHistory("action","potion".$agent);
				break;
				
			case "red":
			case "yellow":
			case "blue":
					$this-&gt;stone-&gt;setColor($action);
					$this-&gt;addToHistory("action",$action.$agent);
				break;
				
			default:
					
				break;
		endswitch;
		<p class='comment'>Add to History, then increment the turn count by one</p>
		$this-&gt;addToHistory("stone-".$this-&gt;stone-&gt;getSize(), $this-&gt;stone-&gt;getColor("str"));
		$this-&gt;turn_count++;
		
	}
	<p class='comment'>calculates the score variable based on the end color of the gem, produced by a combination of two 
		different colors, or one simple color which will yeald a lower score. Then the score is multiplied by the size of the gem.
		And finally the score is returned.</p>
	public function calculateScore(){
		$stone_colors = $this-&gt;stone-&gt;getColor();
		$score;
		sort($stone_colors);
		switch (true):
			case ($stone_colors == array("blue","red")):
					$score = 600;
				break;
			case ($stone_colors == array("blue","yellow")):
					$score = 500;
				break;
			case ($stone_colors == array("red","yellow")):
					$score = 400;
				break;
			case (in_array("blue",$stone_colors)):
					$score = 300;
				break;
			case (in_array("yellow",$stone_colors)):
					$score = 200;
				break;
			case (in_array("red",$stone_colors)):
					$score = 100;
				break;
		endswitch;
		
		$score *=$this-&gt;stone-&gt;getSize();
		
		return $score;
	}
	<p class='comment'>Function to display the outputs of the current turn accross the top of the page. 
		Uses a foreach statement to loop through the turns</p>
	public function displayHistory() {
		$r_str="";
		foreach($this-&gt;getHistory() AS $class):
			$r_str.="&lt;p class='$class'&gt;&lt;/p&gt;";
		endforeach;
		return $r_str;
		
	}
}
<p class='comment'>Function to output the HighScoreTable</p>
class HighScoreTable {
	private $scores=array();
<p class='comment'>Push another player's game into the array.</p>
	public function addToScores($game, $player) {
		array_push($this-&gt;scores, array("player"=&gt;strtoupper($player), "history"=&gt;$game-&gt;getHistory(), "score"=&gt;$game-&gt;calculateScore()));
	}
<p class='comment'>Used in the sortScores function</p>
	private static function compare_scores($a,$b){
		return $a['score']-$b['score'];
	} 
<p class='comment'>Uses compare_score function to help sort the table from highest score to lowest</p>
	public function sortScores() {
		usort($this-&gt;scores,array('HighScoreTable','compare_scores'));
		$this-&gt;scores=array_reverse($this-&gt;scores);
	}
<p class='comment'>For each of the objects in the array, display across the table row.</p>
	public function printScores() {
		$this-&gt;sortScores();
		$r_str = "&lt;table id='highscores' class='bordered'&gt;&lt;thead&gt;&lt;tr&gt;&lt;td colspan='4'&gt;&lt;h3&gt;High Scores&lt;/h3&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/thead&gt;&lt;tr&gt;&lt;th&gt;Rank&lt;/th&gt;&lt;th&gt;Player&lt;/th&gt;&lt;th&gt;Game Summary&lt;/th&gt;&lt;th&gt;Score&lt;/th&gt;";
		$counter = 1;

		foreach($this-&gt;scores AS $rank) {
			$r_str .= "&lt;tr&gt;&lt;td&gt;$counter&lt;/td&gt;&lt;td&gt;".$rank['player']."&lt;/td&gt;&lt;td&gt;";
			foreach($rank['history'] AS $historyItem) {
				$r_str .= "&lt;div class='mini $historyItem'&gt;&lt;/div&gt;";
			}
			$r_str .="&lt;/td&gt;&lt;td&gt;".$rank['score']."&lt;/td&gt;&lt;/tr&gt;";
			$counter++;
		}
		$r_str .= "&lt;/table&gt;";

		echo $r_str;
	}
}
	</pre>
</body>
</html>
	