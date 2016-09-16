<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
session_start();
require_once 'pdo_connect.php';

if (!$_SESSION['loggedin']) {
	die();
} else {

}


function escapeHTML($string) {
	return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

if (isset($_POST['run-crawler'])) {
	$page_num = $_POST['page-number'];
	$page_num = trim(escapeHTML(strip_tags($page_num)));
	echo
	"
	<script>
	window.open('crawler.php?pg=$page_num');
	</script>
	";
}

if (isset($_POST['remove-url'])) {
	$url = $_POST['url'];
	$file_contents = file_get_contents('txt/url_to_crawl.txt');
	$str = str_replace($file_contents, '', $file_contents);
	file_put_contents('txt/url_to_crawl.txt',$str);
}

if (isset($_POST['add-url'])) {
	$url = $_POST['url'];
	$file = "txt/url_to_crawl.txt";
	$bundler = fopen($file, "ab");
	if (filter_var($url, FILTER_VALIDATE_URL)) {
		fwrite($bundler, "$url \n");
	}
	fclose($bundler);
}

function access_secure($str) {
	$access = "password";
	if ($access === $str) {
		return true;
	} else {
		return false;
	}
}

if (isset($_POST['access-code'])) {
	$text = $_POST['access-code'];
	if (access_secure($str)) {
		echo 'access granted. proceeding to empty index....';
		$sql = "TRUNCATE TABLE `colleges`";
		$db = get_database();
		$db->query($sql);
		file_put_contents('url.txt', '');
	} else {
		echo 'wrong access code.';
	}
	echo '<script>document.location = "control-panel.php"</script>';
}

if (isset($_POST['remove-db-row'])) {
	$str = trim($_POST['url-to-remove']);
	$row = trim($_POST['row-to-remove']);
	$sql = "DELETE FROM colleges WHERE $row = :str";
	$db = get_database();
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':str', $str, PDO::PARAM_STR, 12);
	$stmt->execute();
}

if (isset($_POST['insert-to-db'])) {
	$name =            $_POST['insert-name'];
	$link =            $_POST['insert-url'];
	$description =     $_POST['insert-description'];
	
	$sql = "INSERT INTO colleges (name, description, link) VALUES (:name, :description, :link)";
	$db = get_database();
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR, 12);
	$stmt->bindParam(':description', $description, PDO::PARAM_STR, 12);
	$stmt->bindParam(':link', $link, PDO::PARAM_STR, 12);
	$stmt->execute();
	
}

if (isset($_POST['clear-log'])) {
	file_put_contents('txt/searches.txt', '');
}

if (isset($_POST['access-code-query'])) {
	$sql = trim($_POST['query']);
	$access_code = $_POST['access-code-query'];
	if (access_secure($access_code)) {
		$db = get_database();
		$query = $db->query("$sql");
		print_r($query->fetchAll());
	}
}

if (isset($_POST['log-out'])) {
	session_destroy();
	$_SESSION = array();
	echo '<script>document.location = "login.php"</script>';
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Control Panel</title>
	
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta charset='utf-8'> 
	<meta name="viewport" content="width=device-width" />
	
	<link rel="stylesheet" type="Text/css" href="style.css" />
	<link rel="stylesheet" type="text/css" href="control-panel.css" />
	<link rel="icon" href="purelogo.png" type="image/x-icon">	
</head>

<body>
<span id="pure"><img class="unselectable" src="pure-panel-img.png" /></span>
<div class="crawler-settings">
	<span class="crawler-settings-title">Crawler Settings</span>
	<p>
The current urls in the crawler. These urls are waiting to be indexed,
or have already been indexed.
	</p>
	<iframe src="txt/url_to_crawl.txt" class="crawler-iframe"></iframe>
	<p>
<form action="" method="POST">
	<input type="text" class="text-input" name="url" style="width: 50% !important;" autocomplete="off" />
	<input type="submit" value="Remove url" name="remove-url" />
	<input type="submit" value="Add url" name="add-url" />
</form>
	</p>
	<p>
<form action="" method="POST">
	<input type="text" name="page-number" autocomplete="off" size="5" class="text-input" style="float: right;" placeholder="pages" />
	<br><br><br>
	<input type="submit" value="Run crawler" name="run-crawler" style="float: right;" />
</form>
	</p>
</div>

<div class="index" id="index">
	<span class="crawler-settings-title">PureSearch Index</span>
	<br>
	<?php
	$db = get_database();
	$nRows = $db->query('SELECT COUNT(*) FROM colleges')->fetchColumn(); 
	echo "<p>Number of rows in database: $nRows</p>";
	
	?>
	<table>
	<thead>
		<div id="index-head">
		<td class="head">
			<strong>Name</strong>
		</td>
		<td class="head">
			<strong>Description</strong>
		</td>
		<td class="head" style="text-align: left;">
			<strong>Link</strong>
		</td>
		</div>
		</thead>
	</tr>
<?php
$db = get_database();
$sql = "SELECT * FROM colleges LIMIT 500";
foreach($db->query($sql) as $row) {
	echo '<tr>';
	echo '<td>' . @escapeHTML($row['name']) . '</td>';
	echo '<td>' . @escapeHTML($row['description']) . '</td>';
	echo '<td>' . @escapeHTML($row['link']) . '</td>';
	echo '</tr>';
}
?>
	</table>
</div>
<br>
<div class="crawler-settings">
	<span class="crawler-settings-title">Database Actions</span>
	<br>
	<span class="right">
	<p>Perform a query on the database</p>
	
		<textarea name="query" placeholder="query" name="query" id="query-box"></textarea>
		<input type="submit" value="Go" name="db-query" id="query-db" />
	
	</span>
	<span class="left up">
	<p>Remove row from database</p>
	<form action="" method="POST">
		<input type="text" name="url-to-remove" autocomplete="off" class="text-input" style="width: 80%; " />
		<select name="row-to-remove">
			<option>Link</option>
			<option>Name</option>
		</select>
		<input type="submit" name="remove-db-row" value="Remove" />
	</form>
	</span>
	<br><br><br><br><br><br><Br><br><br>
	<p class="mobile-left">Add a row to the database</p>
	<form action="" method="POST" class="netbook">
		<input type="text" placeholder="name" name="insert-name" autocomplete="off" class="text-input" style="width: 45%; padding: 5px;" />
		<input type="text" placeholder="url" name="insert-url" autocomplete="off" class="text-input" style="width: 45%; padding: 5px;" />
		<textarea placeholder="description" name="insert-description"></textarea>
		<input type="submit" value="Insert" name="insert-to-db" />
	</form>
	<input type="submit" value="Empty index" name="empty-index" style="float: right;" id="access-up" />
</div>

<div class="index">
	<span class="crawler-settings-title">Recent Searches</span>
	<br>
	<iframe src="txt/searches.txt" class="iframe-searches" id="log"></iframe>
	<br>
	<form action="" method="POST">
		<input type="submit" value="Empty Log" name="clear-log" />
	</form>
</div>
<div style="height: 5%;"></div>
<form action="" method="POST">
	<input type="submit" name="log-out" value="Log Out" class="logout-button" />
</form>
<hr>

<script type="text/javascript">
function myPop() { 
    this.square = null;
    this.overdiv = null;

    this.popOut = function(msgtxt) {
        //filter:alpha(opacity=25);-moz-opacity:.25;opacity:.25;
        this.overdiv = document.createElement("div");
        this.overdiv.className = "overdiv";

        this.square = document.createElement("div");
        this.square.className = "square";
        this.square.Code = this;
        var msg = document.createElement("div");
        msg.className = "msg";
        msg.innerHTML = msgtxt;
        this.square.appendChild(msg);
        var closebtn = document.createElement("button");
        closebtn.onclick = function() {
            this.parentNode.Code.popIn();
        }
        closebtn.innerHTML = "Close";
        this.square.appendChild(closebtn);

        document.body.appendChild(this.overdiv);
        document.body.appendChild(this.square);
    }
    this.popIn = function() {
        if (this.square != null) {
            document.body.removeChild(this.square);
            this.square = null;
        }
        if (this.overdiv != null) {
        document.body.removeChild(this.overdiv);
        this.overdiv = null;
        }

    }
}


var button = document.getElementById('access-up');
button.addEventListener('click', function() {
    var pop = new myPop();
	pop.popOut("<p>Insert access code to proceed.</p><form action='' method='POST'><input type='password' class='text-input' name='access-code' autocomplete='off' style='width: 50%;' /></form>");
}, false);

var button = document.getElementById('query-db');
button.addEventListener('click', function() {
    var pop = new myPop();
	pop.popOut("<p>Insert access code to proceed.</p><form action='' method='POST'><input type='password' class='text-input' name='access-code-query' autocomplete='off' style='width: 50%;' /> <input type='hidden' name='query' id='query'></form>");
	document.getElementById('query').value = document.getElementById('query-box').value;
}, false);




</script>
</body>

</html>
