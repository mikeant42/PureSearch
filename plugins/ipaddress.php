<?php
require_once('pluginfuncs.php');

function ini_ipaddress($search) {
	if (filter_var($search, FILTER_VALIDATE_IP)) {
				$details = json_decode(file_get_contents("http://ipinfo.io/$search"));
				echo space() . '<div class="definition-box"><span class="definition">
				<a href="http://www.ipinfo.io/'.$search.'">'.$search.'</a> - <br><ul>City: 
				'.$details->city . '<br>Hostname: ' . $details->hostname . '<br>Country: ' . $details->country .  
				'<br>Region: ' . $details->region . '
				</ul>
				
				</span></div>'; 
			}
	}
?>