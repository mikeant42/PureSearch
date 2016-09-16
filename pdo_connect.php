<?php

$host = "---";
$user = "---";
$pass = "---";
$db_name = "purity";

try {
	$db = new PDO("mysql:host=$host;dbname=$db_name", $user, $pass);
	global $db;
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
	echo $e->getMessage();
}

function get_database() {
	global $db;
	return $db;
}

?>
