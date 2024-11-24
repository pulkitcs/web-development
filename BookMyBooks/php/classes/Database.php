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

    function tryQuery($sql) {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      
      return $stmt->fetchAll();
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

    function updateUser($email, $name, $address, $mobile) {
      $sql = "UPDATE users SET name = '$name', address = '$address', mobile = '$mobile' WHERE email = '$email'";

      return $this->executeSQL($sql);
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

    function updateBookStock($ISBN, $quantity, $isIncreasing) {
      $sql = "";

      if($isIncreasing === true) 
        $sql = "UPDATE books SET STOCK=STOCK + '$quantity' WHERE ISBN='$ISBN'";
      else
        $sql = "UPDATE books SET STOCK=STOCK - '$quantity' WHERE ISBN='$ISBN'";

      return $this->executeSQL($sql);
    }

    function createUser($fullname, $username, $repassword, $address, $country, $mobile) {
      $sql = "insert into users (name, email, password, country, mobile, address) values ('$fullname', '$username', '$repassword', '$country', '$mobile', '$address')";

      return $this->executeSQL($sql);
    }

    function adminCreateUser($name, $email, $repassword, $address, $country, $mobile, $admin, $publisher, $disabled, $comments) {
      $sql = "INSERT INTO USERS (name, email, password, country, mobile, address, isAdmin, isPublisher, disabled, admin_comments) VALUES ('$name', '$email', '$repassword', '$country', '$mobile', '$address', '$admin', '$publisher', '$disabled', '$comments')";

      return $this->executeSQL($sql);
    }

    function adminUpdateUser($id, $name, $email, $repassword, $address, $country, $mobile, $admin, $publisher, $disabled, $comments) {
      $sql = "UPDATE users SET name='".$name."', email='".$email."', password='".$repassword."', country='".$country."', mobile='".$mobile."', address='".$address."', isAdmin='".$admin."', isPublisher='".$publisher."', disabled='".$disabled."', admin_comments='".$comments."' where email='".$id."'";

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

    function getOrdersByDate($startDate, $endDate, $status) {
      $sql = '';
      $order_status = 2; // Completed orders

      if($status !== null)
        $order_status = $status;

      if($startDate === null || $endDate === null)
        $sql = "SELECT * FROM orders WHERE STATUS = '$order_status'";
      else 
        $sql = "SELECT * from orders WHERE delivery_date between '$startDate' AND '$endDate' AND STATUS = '2'";
    
      $result = $this->tryQuery($sql);

      return $result;
    }

    function getOrders($user) {
      $sql = "select * from orders where user = '".$user."' ORDER BY order_date DESC";
      $result = $this->executeSQL($sql);

      return $result;
    }

    function adminGetOrders() {
      $sql = "select * from orders ORDER BY order_date DESC";
      $result = $this->executeSQL($sql);

      return $result;
    }
       
    function createOrder($id, $user, $address, $mobile, $details, $cost) {
      $sql = "INSERT INTO orders (id, user, address, mobile, details, cost ) VALUES ('$id', '$user', '$address', $mobile, '$details', '$cost')";
      $sql1 = "UPDATE users set cart = NULL where email='$user'";

      $this->tryQuery($sql);
      $this->tryQuery($sql1);

      $this->extractCart($details, false);
    }
    
    function cancelOrder($orderId) {
      $sql = "UPDATE orders set status = '3' WHERE id='$orderId'";
      $this->tryQuery($sql);

      $result = $this->tryQuery("SELECT details FROM orders WHERE id='$orderId'");
      $this->extractCart($result[0]['details'], true);
    }

    function updateOrder($orderId, $data) {
      $status = $data->status;
      $deliveryDate = $data->deliveryDate;
      $adminComment = $data->adminComment;

      $sql = "UPDATE orders set status = '$status', delivery_date = '$deliveryDate', admin_comments='$adminComment' WHERE id='$orderId'";
      $this->tryQuery($sql);

      if($status === '3') {
        $result = $this->tryQuery("SELECT details FROM orders WHERE ID='$orderId'");
        $this->extractCart($result[0]['details'], true);
      }
    }

    function extractCart($details, $isAdding) {
      $cart = json_decode($details);
      $keys = array_keys(get_object_vars($cart));

      for($n = 0; $n < sizeof($keys); $n++) {
        $isbn = $keys[$n];
        $quantity = $cart->$isbn->quantity;

        $this->updateBookStock($isbn, $quantity, $isAdding);
      }
    }
  }
?>
