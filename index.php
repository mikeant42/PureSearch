<!DOCTYPE html>
<html>
<head>
	<title>Pure Search</title>
	
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta charset='utf-8'> 
	
	<link rel="stylesheet" type="Text/css" href="style.css" />
	<link rel="icon" href="purelogo.png" type="image/x-icon">

	<noscript>
		<meta http-equiv="refresh" content="0; url=html.php" />
	</noscript>
	
<!--  Pure Search Engine  -->
</head>
<body>
<form action="search.php" method="GET">
	<!-- <span id="pure">P<canvas id="c"></canvas>re</span> !-->
	<span id="pure"><img class="unselectable" src="pure.png" /></span>
	<div class="textarea textareaBorder">
	<input id="search" onkeydown="doit();" onkeyup="doit();" class="textarea realTextarea" name="search" autocomplete="off" required autofocus x-webkit-speech />
    <div id="myOtherTextarea" class="textarea overlayTextarea"></div>

	</div>
	<?php echo space(5)  ?>
	<input type="submit" value="Search" id="search-button" />
</form>
<div class="test">
Want to help? <a href="insert-to-crawler.php">Submit a page to crawl</a>.
</div>


<!-- <?php //echo space(15)  ?>
<a href="crawl-page.php" class="crawl-link">Submit a page to crawl</a>
!-->

<script src="input_color.js"></script>
<script type="text/javascript">
function get_random_color() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.round(Math.random() * 15)];
    }
    return color;
}

function clock() {
	azlan = get_random_color();
	document.getElementById("search").style.color = azlan;
}

//var int=self.setInterval(function(){clock()},3000);

document.getElementById('search').focus();



</script>
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