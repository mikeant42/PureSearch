<?php
require_once('pluginfuncs.php');
function ini_alternativesto($search) {
		if (strpos($search, 'alternatives to') !== FALSE) {
			$to = trim(str_replace('alternatives to', '', $search));
			$to = str_replace(' ', '+', $to);
			$count = 6;
			$url = "http://api.alternativeto.net/software/$to/?count=$count";
			@$json = json_decode(file_get_contents($url), true);
			//echo '<pre>' . print_r($json['Items'][1], true) . '</pre>';
			if (!empty($json)) {
				echo space() . '<div class="definition-box"><span class="definition">Alternatives to <strong>'.$to.'</strong>:<ul style="float: left;"><br>';
				for ($i = 0; $i < $count; $i++) {
					echo '<li><a href="'.$json['Items'][$i]['Url'].'">' . $json['Items'][$i]['Name'] . '</a></li>';
				}
				echo '</ul><ul style="float: right;">
				<img src="'.$json['Items'][0]['IconUrl'].'" width="200" height="200" />
				</ul></span></div>';
			}
		}
}
?>