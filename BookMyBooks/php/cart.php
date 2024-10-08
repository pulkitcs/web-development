<?php require_once("./partials/session.php") ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Online store for purchasing books">
    <meta name="keywords" content="ONLINE,BOOKS,STORE,LEARNING">
    <meta name="author" content="pulkit.cs@gmail.com">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome to BookMyBooks</title>
    <?php
      require_once("./partials/font.php");
      require_once("./partials/styles.php");
    ?>
  </head>
  <body>
    <?php
      require_once("./partials/full-header.php");
    ?>
    <main class="main bmb-container">
    <?php
      require_once("./configs/app-config.php");
      require_once("./classes/Database.php");
      

      //$db = new Database($appConfig);
      // $result = $db->getAllBooks();
    ?>
    <?php 
      print_r($result);
    ?>
    </main>
    <?php require_once("./partials/footer.php") ?>
  </body>
</html> 