<!DOCTYPE html>
<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<style>
.center {
    margin-left: auto;
    margin-right: auto;
}
</style>
</head>
<body>

<div align="center">
<h1>FizzBuzz<br><small>by Kevin LeStarge</small></h1>
</div>

<form class="form-inline" action="index.php" method="post">
	<div align="center">
	  <div class="form-group">
	    <input type="text" class="form-control" name="fWord" placeholder="Word 1" required value="">
	  </div>
	  <div class="form-group">
	    <input type="text" class="form-control" name="sWord" placeholder="Word 2" required value="">
	  </div>
	  <br>
	  <div class="form-group">
	    <input type="number" class="form-control" name="num1" placeholder="Divisible Num 1" required value="">
	  </div>
	  <div class="form-group">
	    <input type="number" class="form-control" name="num2" placeholder="Divisible Num 2" required value="">
	  </div>
	  <br>
	    <div class="form-group">
	    <input type="number" class="form-control" name="begin" placeholder="Begin Num" required value="">
	  </div>
	  <div class="form-group">
	    <input type="number" class="form-control" name="end" placeholder="End Num" required value="">
	  </div>
	  <br><br>
	  <button type="submit" class="btn btn-default" >Do math!</button>
  </div>
</form>


	<html>
		<body>

			<div align="center">

			<?php 

				$fWord = $_POST["fWord"];
				$sWord = $_POST["sWord"];
				$num1 = $_POST["num1"];
				$num2 = $_POST["num2"];

				for ($i = $_POST["begin"]; $i <= $_POST["end"]; $i++) {
				    if($i % $num1 and $i % $num2){
				    	echo "<span class=\"label label-default\">$i</span><br>";
				    }
					elseif($i % $num2){
						echo "<span class=\"label label-primary\">$fWord</span><br>";
					}
					elseif($i % $num1){
						echo "<span class=\"label label-warning\">$sWord</span><br>";
					}
					else{
						echo "<span class=\"label label-success\">$fWord $sWord</span><br>";
					}
				} 
			?>

			</div>

		</body>
	</html>
</body>
</html>