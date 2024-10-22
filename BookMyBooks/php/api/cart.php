<?php
  require_once("../configs/app-config.php");
  require_once("../classes/Database.php");

  session_start();

  function success($response) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(202);
    
    echo $response;
  }

  function failure() {
    http_response_code(500);
  }

  function updateCart($db, $body) {
    $title = $body->title;
    $author = $body->author;
    $price = $body->price;
    $quantity = $body->quantity;
    $isbn = $body->isbn;
    $email  = $_SESSION['email'];

    $cart = $db->getCart($email);

    $newCart = array();
    $properties = array();

    if($cart['cart'] !== null)
      $newCart = json_decode($cart['cart'], true);

    $properties['title'] = $title;
    $properties['author'] = $author;
    $properties['price'] = $price;
    $properties['quantity'] = $quantity;

    $newCart[$isbn] = $properties;
    $encodedCart = json_encode($newCart);
    $db->updateCart($email, $encodedCart);
    success($encodedCart); 
  }

  function deleteCartItem($db, $body) {
    $email  = $_SESSION['email'];
    $encodedCart = json_encode($body);
    $db->updateCart($email, $encodedCart);
    success($encodedCart); 
  }

  function main($appConfig) {
    $db = new Database($appConfig);

    if(!$_SESSION['isAuthorized'])
      header("HTTP/1.1 401 Unauthorized");
    else {
      $post_body = file_get_contents('php://input');

      if(isset($post_body) && !isset($_GET['operation'])) {
        updateCart($db, json_decode($post_body));
      } else if(isset($_GET['operation'])) {
        switch ($_GET['operation']) {
          case 'delete':
          default:
          deleteCartItem($db, json_decode($post_body));
        }
      }
      else 
        http_response_code(400);
    }
  }

  main($appConfig);
?>