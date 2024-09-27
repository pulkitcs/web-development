<?php
  $parentDir = dirname(__DIR__);

  require_once(__DIR__."/Configuration.php");
  require_once($parentDir."/configs/app-config.php");
  
  class Database {
    private $conn;

    function __construct($appConfig) {

      // Initialize configs
      $configurations = new Configuration($appConfig);

      $url = $configurations->getKey('url');
      $database = $configurations->getKey('database');
      $username = $configurations->getKey('username');
      $password = $configurations->getKey('password');

      $this->init($url, $database, $username, $password);
    }

    function init($url, $dbName, $username, $password) {
      try {
        $this->conn = new PDO("mysql:host=$url;dbname=$dbName", $username, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }
      catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }
    }

    function getAllBooks() {
      try {
        $sql = "select * from books";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();

        return $result;
      }

      catch(PDOException $e) {
        echo "Unable to execute query". $e->getMessage();
      }
    }

    function getCategories() {
      try {
        $sql = "select * from categories where status=1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();

        return $result;
      }

      catch(PDOException $e) {
        echo "Unable to execute query". $e->getMessage();
      }
    }
  }
?>
