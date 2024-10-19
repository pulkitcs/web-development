<?php session_start() ?>
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

      $db = new Database($appConfig);
      $result = $db->getAllBooks();
    ?>
    <div class="sub-section">
      <div class="side-control">
        <p class="side-heading">Filter</p>
      </div>
      <div>
        <h1 class="heading">Welcome</h1>
      <?php
        $count = sizeOf($result);
        if($count === 0) echo '<p>No Items Found </p>';
        else {
          $str = "";
          for($i = 0; $i < $count; $i++) {
            $ISBN = $result[$i]['ISBN'];
            $name = $result[$i]['name'];
            $price = $result[$i]['price'];
            $author = $result[$i]['author'];
            $publisher = $result[$i]['publisher'];
            $publicationYear = $result[$i]['publication_year'];
            $language = $result[$i]['language'];
            $category = $result[$i]['category'];
            $thumbnail = $result[$i]['thumbnail'];
            
            $str.= "<div>
              <figure>
                <img src='".$thumbnail."' alt='".$name."' height='250' width='200' />
              </figure>
              <div>
                <p>".$name."</p>
                <p>by ".$author." | ".$language." | ".$publicationYear."</p>
                <p>".$publisher."</p>
                <p>".$price."</p>
              </div>
            </div>";
          }

          echo $str;
        }
      ?>
      </div>
    </div>
    </main>
    <?php require_once("./partials/footer.php") ?>
  </body>
</html> 