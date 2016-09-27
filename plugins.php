<?php

require_once('plugins/movie.php');
require_once('plugins/define.php');
require_once('plugins/calculate.php');
require_once('plugins/twittername.php');
require_once('plugins/ipaddress.php');
require_once('plugins/alternativesto.php');
require_once('plugins/wiki.php');
require_once('plugins/calculator.php');


function callAllPlugins($str) {
	ini_movie($str);
	ini_define($str);
	ini_twittername($str);
	ini_ipaddress($str);
	ini_alternativesto($str);
	ini_wiki($str);
	ini_calculate($str);
	ini_calculator($str);
}

?>
