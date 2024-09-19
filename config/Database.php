<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

class Database
{
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $this->host = $_ENV['DB_HOST'];
        $this->db_name = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
    }

    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        return $this->conn;
    }


    public function getAllUrls()
    {
        $stmt = $this->conn->query("SELECT ID, long_url FROM urls");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUrlById($id)
    {
        $query = "SELECT long_url FROM urls WHERE ID = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['long_url'] : null;
    }

    public function insertUrl($url)
    {
        $query = "INSERT INTO urls (long_url, createdAt) VALUES(:long_url, NOW())";
        $stmt = $this->conn->prepare($query);
        $params = array(":long_url" => $url);

        return $stmt->execute($params);
    }
}
