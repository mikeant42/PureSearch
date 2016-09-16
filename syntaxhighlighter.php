<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

function syntax_highlight($str, $code) {
	if ($code === 'php') {
		$str = prettify_php($str);
	}
	return $str;
}

function prettify_php($code) {
	$code = str_replace(array('function', 'return', 'array'), array('<span class="keyword">function</span>','<span class="keyword">return</span>','<span class="keyword">array</span>'), $code);
	//$code = preg_replace('/[^0-9]/', '<span class="number">$1</span>', $code);
	$code = preg_replace('/(?<=^|(?<=[^a-zA-Z0-9-\.]))$([A-Za-z_]+[A-Za-z0-9_]+)/', '<span class="var-name">$$1</span>', $code);
	$code = "<div class='code-box'>$code</div>";
	return $code;
}

?>
