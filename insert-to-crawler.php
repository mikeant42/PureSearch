<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();

if (isset($_POST['url-writer'])) {
	$url = trim($_POST['url-writer']);
	$file = "txt/url_to_crawl.txt";
	$bundler = fopen($file, "ab");
	if (filter_var($url, FILTER_VALIDATE_URL)) {
		fwrite($bundler, "$url \n");
	}
	fclose($bundler);
}
	$file = "txt/url_to_crawl.txt";

?>

<!DOCTYPE html>
<html>
<head>
	<title>Insert URL into PureSpider</title>
	
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta charset='utf-8'> 
	
	<link rel="stylesheet" type="Text/css" href="style.css" />
	<link rel="icon" href="purelogo.png" type="image/x-icon">	
</head>

<body>

<form action="" method="POST">
	<p class="text" style="text-align: center;">
		Enter the url for our spider to crawl: <input type="Text" class="text-input" style="margin: 0 auto;" name="url-writer" autocomplete="off" />
	</p>
</form>
<hr>
<p class="text" style="Text-align: center;">List of urls in our crawler.</p>
<iframe src="<?php echo $file;  ?>" style="width: 95%; background: white; height: 50%; border: gray;"></iframe>


<?php

$loggedin = $_SESSION['loggedin'];
if ($loggedin) {

?>

eqfgegrwgwtg

<?php
}
?>

</body>

</html>