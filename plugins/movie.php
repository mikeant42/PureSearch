<?php
require_once('pluginfuncs.php');
	function ini_movie($search) {
		if (strtok($search, " ") === 'movie') {
			$movie_search = trim(str_replace(' ', '+', $search));
			$movie_search = str_replace('movie', '', $movie_search);
			$movie_url = "http://deanclatworthy.com/imdb/?q=$movie_search";
			$json_movie = file_get_contents($movie_url);
			
				$movie_search = escapeHTML(str_replace('+', ' ', $movie_search));
				$json = json_decode($json_movie, true);
				//echo '<pre>' . print_r($json, true) . '</pre>';
				echo space() . '<div class="definition-box"><span class="definition"><a href="'.$json['imdburl'].'">'. $json['title'] . '</a>:<ul>
				Rating: '. $json['rating'] .' / 10<br>Generes: '. $json['genres'] .'<br>Runtime: '. $json['runtime'] .'<br>Year: '. $json['year'] .'
				<br>Country: '. $json['country'] .'<br>Language(s): '. $json['languages'] .'
				</ul></span></div>';
		}
	}
?>