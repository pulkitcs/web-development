<?php
  require_once("../configs/app-config.php");
  require_once("../classes/Database.php");

  session_start();

  function success($response) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(202);
    
    echo $response;
  }

  function getCost($json) {
    $json_decoded = json_decode($json);
    $keys = array_keys(get_object_vars($json_decoded));
    $total = 0;

    for($i = 0; $i < sizeof($keys); $i++) {
      $isbn = $keys[$i];
      $price = $json_decoded->$isbn->price;
      $quantity = $json_decoded->$isbn->quantity;
      $total .= $price*$quantity;
    }

    return $total;
  }

  function listOrders($db) {
    $startdate = null;
    $enddate = null;
    $status = isset($_GET['status']) ? $_GET['status'] : null;

    if(isset($_GET['startdate']) && isset($_GET['enddate'])) {
      $startdate = $_GET['startdate'];
      $enddate = $_GET['enddate'];
    }

    try {
      $result = $db->getOrdersByDate($startdate, $enddate, $status);
      success(json_encode($result));
    }
    catch(Exception $e) {
      http_response_code(500);
      $e->getMessage();
    }
  }

  function createOrder($db, $username) {
    $userDetails = $db->getUser($username);

    $json = $userDetails['cart'];
    $address = $userDetails['address'];
    $mobile = $userDetails['mobile'];
    $cost = getCost($json);
    $id = uniqid();

    try {
      $db->createOrder($id, $username, $address, $mobile, $json, $cost);
    }
    catch(PDOException $e) {
      http_response_code(500);
    }
  }

  function cancelOrder($db, $orderId) {
    try {
      $db->cancelOrder($orderId);
    }
    catch(PDOException $e) {
      echo $e->getMessage();
      http_response_code(500);
    }
  }

  function UpdateOrder($db, $orderId, $data) {
    try {
      $db->updateorder($orderId, $data);
    }
    catch(PDOException $e) {
      echo $e->getMessage();
      http_response_code(500);
    }
  }

  function postRequests($db, $isAdmin, $username) {
    $post_body = file_get_contents('php://input');
    $opCode = json_decode($post_body);
    $operation = $opCode->operation;
    $orderId = $opCode->orderId;

    if(isset($post_body)) {
      switch($operation) {
        case 'create': {
          createOrder($db, $username);
          break;
        }
        case 'update': {
          $data = $opCode->data;
          updateOrder($db, $orderId, $data);
        }
          break;
        case 'cancel':
          cancelOrder($db, $orderId);
          break;
        default:
          http_response_code(400);
      }
    } else {
      http_response_code(400);
    }
  }

  function main($appConfig) {
    $db = new Database($appConfig);
    $isAdmin = $_SESSION['isAdmin'];
    $username = $_SESSION['email'];

    if(!$_SESSION['isAuthorized'])
      header("HTTP/1.1 401 Unauthorized");
    else {
      switch($_SERVER['REQUEST_METHOD']) {
        case "GET":
        default:
          listOrders($db);
          break;
        case "POST":
          postRequests($db, $isAdmin, $username);
          break;
      }
    }
  }

  main($appConfig);
?>