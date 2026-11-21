<?php 
  session_start();

  function redirect() {
    header('Location: login.php?redirect='.$_SERVER['REQUEST_URI']);
    exit();
  }

  if(!isset($_SESSION['isAuthorized'])) {
    redirect();
  }
  
  if(isset($_SESSION['isAuthorized'])) {
    if($_SESSION['isAdmin'] !== "1")
      redirect();
  }
?>