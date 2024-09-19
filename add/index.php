<?php
include '../config/Database.php';

$database = new Database();
$db = $database->connect(); 

$url = $_POST['long_url'];

$query = "INSERT INTO urls (long_url, createdAt) VALUES(:long_url, NOW())";$stmt = $db->prepare($query);
$params = array(":long_url" => $url); 

$result = $stmt->execute($params);

var_dump($result);
?>
