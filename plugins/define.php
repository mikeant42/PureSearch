<?php
require_once 'pluginfuncs.php';
	function ini_define($search) {
		if (strtok($search, " ") === 'define') {
			$search = preg_replace('/(define)/', '', $search);
			$dict_url = str_replace(' ', '', "http://www.thefreedictionary.com/$search");
			$div = "ds-list";
			
			$config = array(
			  'indent' => 'true',
			  'output-xhtml' => 'true',
			  'wrap          => 200'
			);
			@$tidy = tidy_parse_string(file_get_contents($dict_url), $config, 'utf8');
			$tidy->cleanRepair();
			
			$doc = new DomDocument;
			@$doc->loadHTML($tidy);
			@$definition = getElementsByClassName($doc, $div);
			if ($definition == "") {
				echo '';
			} else {
				echo space() . "<div class='definition-box'><span class='definition'>The definition of <strong>$search</strong> <br><ul><em>$definition</em></ul>
				Read more at <a href='http://www.thefreedictionary.com/$search'>The Free Dictionary</a></span></div>";
			}
		}
	}
?>