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

    function executeSQL($sql) {
      try {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        return $stmt->fetchAll();
      }

      catch(PDOException $e) {
        echo "Unable to execute query". $e->getMessage();
      }
    }

    function authenticateUser($username, $password) {
      $sql = "select * from users where email='$username' and password='$password'";
      $result = $this->executeSQL($sql);

      return sizeOf($result) === 1;
    }

    function getUser($username) {
      $sql = "select * from users where email='".$username."'";
      $result = $this->executeSQL($sql);

      return $result[0];
    }

    function getAllBooks() {
      $sql = "select * from books";
      return $this->executeSQL($sql);
    }

    function getCategories() {
      $sql = "select * from categories where status=1";
      return $this->executeSQL($sql);
    }

    function createUser($fullname, $username, $repassword, $address, $country, $mobile) {
      $sql = "insert into users (name, email, password, country, mobile, address) values ('$fullname', '$username', '$repassword', '$country', '$mobile', '$address')";

      return $this->executeSQL($sql);
    }
  }
?>
