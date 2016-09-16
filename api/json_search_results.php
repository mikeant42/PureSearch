<?php
require_once '../pdo_connect.php';

function makeJSONResponse($array, $limit) {
	
}

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
	foreach ($result as $row) {
		$i++;
		$desc = strToLower($desc);
		$json[$i]['title'] = $row['name'];
		$json[$i]['description'] = $row['description'];
		$json[$i]['link'] = $row['link'];
		//echo $json[$i]['title'];
		//echo $json[$i]['description'];
		//echo $json[$i]['link'];
	}
	return json_encode($json);
}

$search_term = strToLower(trim($_GET['search']));
$json_results = query($search_term, 15);
print_r($json_results);
?>