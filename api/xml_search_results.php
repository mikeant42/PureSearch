<?php
header('Content-type: text/xml');
require_once '../pdo_connect.php';
echo '<?xml version="1.0" encoding="utf-8"?>';

function query($search, $limit) {
		$sql = "
		SELECT SQL_CALC_FOUND_ROWS DISTINCT * FROM colleges WHERE MATCH(description) AGAINST(:search IN BOOLEAN MODE) LIMIT 0, :finish
		";
		$search = '%' . $search . '%';
		$db = get_database();
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':search', $search, PDO::PARAM_STR, 12);
		$stmt->bindParam(':finish', $limit, PDO::PARAM_STR, 12);
		$stmt->execute();
		$results = $stmt->fetchAll();
		return returnDBResponse($results);
}

function returnDBResponse($result) {
	$json = array();
	$i = 0;
	echo "<searchresults>";
	foreach ($result as $row) {
		$i++;
		$desc = strToLower($desc);
		$json[$i]['title'] = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;',$row['name']);
		$json[$i]['description'] = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;',$row['description']);
		$json[$i]['link'] = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;',$row['link']);
		echo "<result>";
		if (!empty($json[$i]['title']))
			echo '<title>' . $json[$i]['title'] . '</title>';
		else
			echo '';
		if (!empty($json[$i]['description'])) 
			echo '<description>' . $json[$i]['description'] . '</description>';
		else 
			echo '';
		if (!empty($json[$i]['link'])) 
			echo '<link>' . $json[$i]['link'] . '</link>';
		else
			echo '';
		echo "</result>";
	}
	echo "</searchresults>";
}



$search_term = strToLower(trim($_GET['search']));
$json_results = query($search_term, 15);

  
?>
