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

  function createOrder($db, $isAdmin, $body) {

  }

  function UpdateOrder($db, $isAdmin, $body) {

  }

  function main($appConfig) {
    $db = new Database($appConfig);
    $isAdmin = $_SESSION['isAdmin'];

    if(!$_SESSION['isAuthorized'])
      header("HTTP/1.1 401 Unauthorized");
    else {
      $post_body = file_get_contents('php://input');

      if(isset($post_body) && !isset($_GET['operation'])) {
        createOrder($db, $isAdmin, json_decode($post_body));
      } else if(isset($_GET['operation'])) {
        switch ($_GET['operation']) {
          case 'update':
          default:
          UpdateOrder($db, $isAdmin, json_decode($post_body));
        }
      }
      else 
        http_response_code(400);
    }
  }

  main($appConfig);
?>