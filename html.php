<!DOCTYPE html>
<html>
<head>
	<title>Pure Search</title>
	
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta charset='utf-8'> 
	
	<link rel="stylesheet" type="Text/css" href="style.css" />
	<link rel="icon" href="purelogo.png" type="image/x-icon">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

	
<!--  Pure Search Engine  -->
</head>
<body>
<form action="search.php" method="GET">
	<!-- <span id="pure">P<canvas id="c"></canvas>re</span> !-->
	<span id="pure"><img class="unselectable" src="pure.png" /></span>
	<input id="search" name="search" autocomplete="off" style="color: gray;" required autofocus x-webkit-speech />

	<?php echo space(5)  ?>
	<input type="submit" value="Search" id="search-button" />
</form>
<div class="test">
Want to help? <a href="insert-to-crawler.php">Submit a page to crawl</a>.
</div>


<!-- <?php //echo space(15)  ?>
<a href="crawl-page.php" class="crawl-link">Submit a page to crawl</a>
!-->
</body>
</html>
<?php

function space($count) {
	$azlan = "";
	for ($i = 0; $i <= $count; $i++) {
		$azlan = $azlan . '<br>';
	}
	return $azlan;
}


?>