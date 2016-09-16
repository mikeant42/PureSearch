<?php
require 'crawler_class/libs/PHPCrawler.class.php';
require 'pdo_connect.php';
error_reporting(E_ALL);
ini_set('display_errors',1);
set_time_limit(10000);



// Extend the class and override the handleDocumentInfo()-method  
class PureSpider extends PHPCrawler  
{ 

  function handleDocumentInfo($DocInfo)  
  { 
	$url_list = fopen('url.txt', 'ab');
    // Just detect linebreak for output ("\n" in CLI-mode, otherwise "<br>"). 
    if (PHP_SAPI == "cli") $lb = "\n"; 
    else $lb = "<br />"; 
		
		$url = $DocInfo->url;

    // Print the URL and the HTTP-status-Code 
    echo "Page requested: ".$url." (".$DocInfo->http_status_code.")".$lb; 
     
    // Print the refering URL 
    echo "Referer-page: ".$DocInfo->referer_url.$lb; 
    	
	
    // Print if the content of the document was be recieved or not 
    if ($DocInfo->received == true) 
      echo "Content received: ".$DocInfo->bytes_received." bytes".$lb; 
    else 
      echo "Content not received".$lb;  
     
    // Now you should do something with the content of the actual 
    // received page or file ($DocInfo->source), we skip it in this example
	$source = $DocInfo->source;
	if (preg_match('/<title>(.+)<\/title>/', $source, $matches) && isset($matches[1] )) {
		$title = $matches[1];
	} else {
		$title = 'not found';
	}
	
	echo 'title: <b>' . htmlentities($matches[1]) . '</b>';
	echo $lb;
	
	$tags = get_meta_tags($DocInfo->url);
	echo 'description: <i>' . htmlentities($tags['description']) . '</i><br />';
	
     
    echo $lb;
		
	$title = sql_secure($title);
	$desc = sql_secure($tags['description']);
	$url = sql_secure($url);
	$table = 'colleges';
	
	if (isset($title) || isset($desc) || isset($url)) {

		$contents = file_get_contents('url.txt');
		if (strpos($contents, $url) !== FALSE) {
			echo "we have the url";
		} else { 
			echo 'this is a new url';
			fwrite($url_list, "$url \n");
			$sql = "INSERT IGNORE INTO colleges SET name='$title', description='$desc', link='$url';";
			if ($results = custom_query($sql)) {
				echo '<br>inserted<br>';
			} else {
				echo "fauilure" . error_message();
			}
		}
		/////////////////end
	}
	
     
    flush(); 
	fclose($url_list);
  }
}

function sql_secure($str) {
	return trim(strip_tags(custom_escape_string($str)));
}

function insertIntoTable($content, $column) {
	$sql = "INSERT INTO colleges ('$column') VALUES('$content');";
	if ($results = custom_query($sql)) {
		echo '<br>inserted<br>';
	} else {
		echo "fauilure" . error_message();
	}
} 

// Now, create a instance of your class, define the behaviour 
// of the crawler (see class-reference for more options and details) 
// and start the crawling-process.  

$number_of_pages = $_GET['pg'];

$crawler = new PureSpider(); 

// URL to crawl 
$crawler->addContentTypeReceiveRule("#text/html#"); 
$crawler->addURLFilterRule("#\.(jpg|jpeg|gif|png)$# i");
$crawler->addURLFilterRule("#(css|js|java|py|pl)$# i");
$crawler->enableCookieHandling(true);  
//$crawler->setTrafficLimit(1000 * 1024);
$crawler->setPageLimit($number_of_pages);
$crawler->enableAggressiveLinkSearch(FALSE);
$crawler->setUserAgentString("PureSpider");
$crawler->obeyRobotsTxt(TRUE);

/*
* This crawler will obey robots.txt(don't want to get into any legal issues), 
* and link rel='nofollow'. It will not follow 
* url's with the extension of an image, css, or javascript file, and will only recieve
* text/html files(probably will change).
*/

$url_file = fopen('txt/url_to_crawl.txt', "r");

while (!feof($url_file)) {
	$website = fgets($url_file);
	$website = trim($website);
	echo $website;
	$crawler->setURL($website); 
	$crawler->go();
}


// At the end, after the process is finished, we print a short 
// report (see method getProcessReport() for more information) 
$report = $crawler->getProcessReport(); 

if (PHP_SAPI == "cli") $lb = "\n"; 
else $lb = "<br />"; 
     
echo "Summary:".$lb; 
echo "Links followed: ".$report->links_followed.$lb; 
echo "Documents received: ".$report->files_received.$lb; 
echo "Bytes received: ".$report->bytes_received." bytes".$lb; 
echo "Process runtime: ".$report->process_runtime." sec".$lb; 


?>
