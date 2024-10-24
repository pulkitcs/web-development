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
      $sql = "select * from users where email='$username' and password='$password' and disabled='0'";
      $result = $this->executeSQL($sql);

      return sizeOf($result) === 1;
    }
    
    function getUser($username) {
      $sql = "select * from users where email='".$username."'";
      $result = $this->executeSQL($sql);

      return $result[0];
    }

    function getAllUsers() {
      $sql = "select * from users";
      $result = $this->executeSQL($sql);

      return $result;
    }

    function getCategories() {
      $sql = "select * from categories where status=1";
      return $this->executeSQL($sql);
    }

    function adminGetCategories() {
      $sql = "select * from categories";
      return $this->executeSQL($sql);
    }

    function getAllBooks($category, $search) {
      $sql = "SELECT * FROM books WHERE stock > 0 AND disabled = '0'";

      if($category !== null && $category !== 'all') {
        $sql .= "AND category = '".$category."'";
      }

      if($search !== null && $search !== '') {
        $sql .= "AND name LIKE '%".$search."%' OR author like '%".$search."%' OR publisher like '%".$search."%'";
      }

      return $this->executeSQL($sql);
    }

    function adminGetAllBooks() {
      $sql = "SELECT * FROM books";
      return $this->executeSQL($sql);
    }

    function adminGetBookDetails($ISBN) {
      $sql = "SELECT * FROM books where ISBN = '$ISBN'";
      $result = $this->executeSQL($sql);

      return $result[0];
    }

    function addBook($ISBN, $title, $price, $author, $publisher, $publication_year, $language, $category, $thumbnail, $disabled, $stock, $discount) {
      $sql="INSERT INTO BOOKS (ISBN, name, price, author, publisher, publication_year, language, category, thumbnail, disabled, stock, discount) VALUES ('$ISBN', '$title', '$price', '$author', '$publisher', '$publication_year', '$language', '$category', '$thumbnail', '$disabled', '$stock', '$discount')";

      return $this->executeSQL($sql);
    }

    function adminUpdateBookDetails($id, $ISBN, $title, $price, $author, $publisher, $publication_year, $language, $category, $thumbnail, $disabled, $stock, $discount) {
      $sql = "UPDATE books SET ISBN='$ISBN', name='$title', price='$price', author='$author', publisher='$publisher', publication_year='$publication_year', language='$language', category='$category', thumbnail='$thumbnail', disabled='$disabled', stock='$stock', discount='$discount' WHERE ISBN='$id'";

      return $this->executeSQL($sql);
    }

    function createUser($fullname, $username, $repassword, $address, $country, $mobile) {
      $sql = "insert into users (name, email, password, country, mobile, address) values ('$fullname', '$username', '$repassword', '$country', '$mobile', '$address')";

      return $this->executeSQL($sql);
    }

    function adminCreateUser($name, $email, $repassword, $address, $country, $mobile, $admin, $disabled, $comments) {
      $sql = "INSERT INTO USERS (name, email, password, country, mobile, address, isAdmin, disabled, admin_comments) VALUES ('$name', '$email', '$repassword', '$country', '$mobile', '$address', '$admin', '$disabled', '$comments')";

      return $this->executeSQL($sql);
    }

    function adminUpdateUser($id, $name, $email, $repassword, $address, $country, $mobile, $admin, $disabled, $comments) {
      $sql = "UPDATE users SET name='".$name."', email='".$email."', password='".$repassword."', country='".$country."', mobile='".$mobile."', address='".$address."', isAdmin='".$admin."', disabled='".$disabled."', admin_comments='".$comments."' where email='".$id."'";

      return $this->executeSQL($sql);
    }

    function getCart($email) {
      $sql = 'SELECT cart FROM users WHERE email="'.$email.'"';
      $result = $this->executeSQL($sql);

      return $result[0];
    }

    function updateCart($email, $cart) {
      // need to still encode here
      $json = json_encode($cart);

      $sql = 'UPDATE users SET cart='.$json.' WHERE email="'.$email.'"';
      $result = $this->executeSQL($sql);

      return $result;
    }
  }
?>
