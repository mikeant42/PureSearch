<?php
require_once('pluginfuncs.php');
function ini_wiki($search) {
	if (strtok($search, " ") === 'wiki') {
				$search = preg_replace('/(wiki)/', '', $search);
				//$search = str_replace(' ', '_', $search);
				$search = trim($search);
				$search = ucfirst($search);
				$url = "http://en.wikipedia.org/w/api.php?action=parse&page=$search&format=json&prop=text&section=0";
				$ch = curl_init($url);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt ($ch, CURLOPT_USERAGENT, "Anon"); // required by wikipedia.org server; use YOUR user agent with YOUR contact information. (otherwise your IP might get blocked)
				$c = curl_exec($ch);

				$json = json_decode($c);

				$content = $json->{'parse'}->{'text'}->{'*'}; // get the main text content of the query (it's parsed HTML)

				// pattern for first match of a paragraph
				$pattern = '#<p>(.*)</p>#Us'; // http://www.phpbuilder.com/board/showthread.php?t=10352690
				if(preg_match($pattern, $content, $matches))
				{
					// print $matches[0]; // content of the first paragraph (including wrapping <p> tag)]
					echo  space() . '<div class="definition-box"><span class="definition">From <a href="http://en.wikipedia.org/wiki/'.$search.'">Wikipedia</a>:<br>';
					echo '<em><ul>' . strip_tags($matches[1]) . '</em></ul></span></div>'; // Content of the first paragraph without the HTML tags.
	}
			}
}
?>