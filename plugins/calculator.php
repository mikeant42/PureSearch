<?php
require_once('pluginfuncs.php');

function ini_calculator($search) {
	if ($search == "calculator") {
		echo space() . '<div class="definition-box">
		<span class="definition">
		<iframe class="caculator" src="http://web2.0calc.com/widgets/horizontal/" scrolling="no" "> </iframe>
		</span></div>';
			}
	}
?>