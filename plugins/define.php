<?php
require_once 'pluginfuncs.php';
	function ini_define($search) {
		if (strtok($search, " ") === 'define') {
			$search = preg_replace('/(define)/', '', $search);
			$html = file_get_contents($dict_url);
			$dom = new DOMDocument();
			@$dom->loadHTML($html); // Show no errors on missformed HTML ;-)
			$xpath = new DOMXpath($dom);
			$note = $xpath->query('//div[contains(@class, "ds-list")]');
			$definition = str_replace('1. ', '', trim(@$note->item(0)->nodeValue));
			if ($definition != '') {
				echo space() . "<div class='definition-box'><span class='definition'>The definition of <strong>$search</strong> <br><ul><em>$definition</em></ul>
				Read more at <a href='http://www.thefreedictionary.com/$search'>The Free Dictionary</a></span></div>";
			}
		}
	}
?>
