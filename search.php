<!DOCTYPE html>
<html>
<head>
	<title>Search - <?php  echo escapeHTML($_GET['search'])  ?></title>
	<link rel="stylesheet" type="Text/css" href="style.css" />
	<link rel="icon" href="purelogo.png" type="image/x-icon">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

	<meta charset='utf-8'>
</head>
<body>
<?php
function nextPage() {
	$page = "";
	if (isset($_GET['pg'])) {
		$page = $_GET['pg'];
	}
	$page = explode(',', $page);
	$start_num = intval($page[0]);
	$finish_num = intval($page[1]);
	return incrementBy($start_num, 10) . ',' . incrementBy($finish_num, 10);
}


function incrementBy($int, $ii) {
	for ($i = 0; $i < $ii; $i++) {
		$int++;
	}
	return $int;
}

function previousPage() {
	$page = "";
	if (isset($_GET['pg'])) {
		$page = $_GET['pg'];
	}
	$page = explode(',', $page);
	$start_num = intval($page[0]);
	$finish_num = intval($page[1]);
	$done = decreaseBy($start_num, 10) . ',' . decreaseBy($finish_num, 10);
	if (decreaseBy($start_num, 10) < 0) {
		return 0;
	} else {
		return $done;
	}
}

function decreaseBy($int, $ii) {
	for ($i = 0; $i < $ii; $i++) {
		$int--;
	}
	return $int;
}

?>
<form action="" method="GET">
	<div class="search-bar">
		<input type="text" placeholder="search" name="search" id="search-top" value="<?php echo $_GET['search'];  ?>" autocomplete="off" onfocus="this.value = this.value;" required autofocus x-webkit-speech />
		<input type="hidden" name="pg" value="0,10" />
		<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
		<a href="?search=<?php echo $_GET['search']; ?>&pg=<?php echo previousPage(); ?>">&lt; Previous Page</a>
		&nbsp;&nbsp;&nbsp;
		<a href="?search=<?php echo $_GET['search']; ?>&pg=<?php echo nextPage(); ?>">Next Page &gt;</a>
		<?php
		$page = "";
		if (isset($_GET['pg'])) {
			$page = $_GET['pg'];
		}
		$page = explode(',', $page);
		$start_num = $page[0];
		$finish_num = $page[1];
		echo '<br><span style="margin-left: 75%; position: relative; top: -5px;">' . escapeHTML($start_num) . ' - ' . escapeHTML($finish_num) . '</span>';
		?>
	</div>
</form>


<script>
function clearSelection() {
    if ( document.selection ) {
        document.selection.empty();
    } else if ( window.getSelection ) {
        window.getSelection().removeAllRanges();
    }
}

var searchbox = document.getElementById('search-top');
//searchbox.word.focus();
//searchbox.word.value = searchbox.word.value;


</script>


<?php
require 'pdo_connect.php';
require 'plugins.php';
ini_set('display_errors',1);
error_reporting(E_ALL);
date_default_timezone_set('America/New_York');


function escapeHTML($string) {
	return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}


function space() {
	$space = "<br><br><br><br><br><br><br>";
	return $space;
}



function get_and_show_results($result) {
	$name = array();
	$description = array();
	$term = $_GET['search'];
	//$term = explode(" ", $term);
	foreach ($result as $row) {
		$desc = $row['description'];
		$desc = strToLower($desc);
		$desc = highlight($desc, $term);
		echo '<div class="result">
		<b><span style="margin-left: 20px;"><a href="' . escapeHTML($row['link']) . '">' . escapeHTML($row['name']) . '</a></span></b>
		<p>' . limit_size($desc, 200) . '</p><span style="color: lightblue">'. escapeHTML(url_size($row['link'], 60)) .'</span></div><br><br><br><br><Br><Br><br><br><br>';
	}
}

function highlight($text, $words) {
    preg_match_all('~\w+~', $words, $m);
    if(!$m)
        return $text;
    $re = '~\\b(' . implode('|', $m[0]) . ')\\b~';
    return preg_replace($re, '<span class="bubble">$0</span>', $text);
}

function limit_size($str, $width) {
    return current(explode("\n", wordwrap($str, $width, "...\n")));
}

function url_size($url, $width) {
	if (strlen($url) >= $width) {
		$url = substr($url, 0, $width) . '...';
	}
	return $url;
}

function GetIP()
{
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key)
    {
        if (array_key_exists($key, $_SERVER) === true)
        {
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip)
            {
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false)
                {
                    return $ip;
                }
            }
        }
    }
}

function log_search($str) {
	$day=date("l");
	$date=date("j");
	$suffix=date("S");
	$month=date("F");
	$year=date("Y");
	$logging_date = $day . ", " . $month . " " . $date . $suffix . ", " . $year;
	
	$logging_content = PHP_EOL . GetIP() . ' - ' . $logging_date . ' - ' . $str;
	
	$handler = fopen('txt/searches.txt', "ab");
	fwrite($handler, $logging_content);
	fclose($handler);

}

if (isset($_GET['search'])) {
	$search = $_GET['search'];
	$search = strToLower(trim($search));
	log_search($search);
	if (strlen(trim($search)) < 3) {

	} else {
		$search = '%' . $search . '%';
		
		
		//$sql = "SELECT DISTINCT * FROM colleges WHERE name LIKE :search"; // add DISTINCT
		$page = "";
		if (isset($_GET['pg'])) {
			$page = $_GET['pg'];
		}
		$page = explode(',', $page);
		$start_num = $page[0];
		$finish_num = $page[1];
			
		
		$sql = "
		SELECT SQL_CALC_FOUND_ROWS DISTINCT * FROM colleges WHERE MATCH(description) AGAINST(:search IN BOOLEAN MODE) LIMIT :start, :finish
		";
		
		$db = get_database();
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':search', $search, PDO::PARAM_STR, 12);
		$stmt->bindParam(':start', $start_num, PDO::PARAM_STR, 12);
		$stmt->bindParam(':finish', $finish_num, PDO::PARAM_STR, 12);
		$startTime = microtime(true);
		$stmt->execute();
		$qTime = microtime(true) - $startTime;
		$results = $stmt->fetchAll();
		$num_results = $stmt->rowCount();
		$search = str_replace('%','',$search);
		
		
		/*
		This is where the plugins are initiated. Authors/makers of plugins stated in plugins.php
		Function:
			ini_nameofplugin($nameofsearchstring);
		*/
		callAllPlugins($search);
		

		
		$sql2 = "SELECT FOUND_ROWS();";
		$number_of_rows = $db->query($sql2);
		$number_of_rows = $number_of_rows->fetchColumn();
		echo space() . "<span class='search-return'>Your term returned $number_of_rows result(s) in $qTime seconds<br><br>";
		get_and_show_results($results);
		
		}
	}







?>


</body>
</html>

