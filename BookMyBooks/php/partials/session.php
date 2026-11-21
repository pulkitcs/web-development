<?php 
  session_start();

  if(!isset($_SESSION['isAuthorized'])) {
    header('Location: login.php?redirect='.$_SERVER['REQUEST_URI']);
    exit();
  }
?>