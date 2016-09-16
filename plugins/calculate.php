<?php
require_once('pluginfuncs.php');
function ini_calculate($search) {
	if (strtok($search, " ") === 'calculate') {
		include 'do_calculate.php';
		$new = trim(str_replace('calculate', '', $search));
		$result = calculate($new);
		echo space() . "<div class='definition-box'><span class='definition'>$new = $result<br>Is this wrong? Use the <a href='http://stevenazlan.com/test/search/search.php?search=Calculator&pg=0%2C10'>Calculator</a></span></div>";
	}
}
?>