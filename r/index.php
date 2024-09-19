<?php
include '../config/Database.php';

$database = new Database();
$db = $database->connect();

if (isset($_GET['c'])) {
    $id = $_GET['c'];

    $url = $database->getUrlById($id);

    if ($url) {
        header("Location: " . $url);
        exit;
    } else {
        echo 'URL not found!';
    }
} else {
    echo 'Invalid URL!';
}
?>
