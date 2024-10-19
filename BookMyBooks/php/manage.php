<?php require_once("./partials/admin-session.php"); ?>
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
    <style>
      .sub-section > .nav ul {
        list-style: none;
        border:  solid thin var(--background-gray);
      }

      .sub-section >.nav li {
        padding: .5rem 1rem .5rem 1rem;
        font-size: 1.3rem;
        background-color: var(--background-cream);
      }
      
      .sub-section >.nav li.active {
        background-color: var(--bg-light-highlight);
      }

      .sub-section >.nav li a {
        text-decoration: none;
        text-transform: capitalize;
      }

      .sub-section >.nav li a > i {
        margin-right: .3rem;
      }
    </style>
  </head>
  <body>
    <?php
      require_once("./partials/full-header.php");
    ?>
    <main class="main bmb-container">
      <div class="sub-section">
        <nav class="nav side-control">
          <p class="side-heading">Navigate To</p>
        </nav>
        <section>
          <?php
            $topics = array("default" => "orders", "users" => "users", "books" => "books");
            $pages = array("orders" => "./manage-orders.php", "users" => "./manage-users.php", "books" => "./manage-books.php");
            $iconsClass = array("orders" => "fa fa-shopping-cart", "users" => "fa fa-users", "books" => "fa fa-book");
          ?>
          <h1 class="heading">Manage <?= isset($_GET['type']) ? $_GET['type'] : $topics["default"] ?></h1>
          <?php
            if(isset($_GET["type"])) {
              $pageType = strtolower($_GET["type"]);

              switch($pageType) {
                case "orders":
                default:
                  require_once($pages[$topics["default"]]);
                  break;
                case "users":
                  require_once($pages[$topics["users"]]);
                  break;
                case "books":
                  require_once($pages[$topics["books"]]);
              }
            }
          ?>
        </section>
      </div>
    </main>
    <?php require_once("./partials/footer.php"); ?>
    <script>
      const topics = <?php
        $str = '{';
        foreach ($topics as $key => $value) {
          $str.= $key.':"'. $value.'",';
        }
        $str.= '}'; 

        echo $str;
      ?>

      const pages = <?php
        $str = '{';
        foreach ($pages as $key => $value) {
          $str.= $key.':"'. $value.'",';
        }
        $str.= '}'; 

        echo $str;
      ?>

      const icons = <?php
        $str = '{';
        foreach ($iconsClass as $key => $value) {
          $str.= $key.':"'. $value.'",';
        }
        $str.= '}'; 

        echo $str;
      ?>

      const page = '<?= isset($_GET['type']) ? strtolower($_GET['type']) : $topics["default"]; ?>';
      const elem = document.querySelector(".sub-section > .nav");
      const ul = document.createElement('ul');;

      const leftNavItems = Object.values(topics).map((name) => {
        const li = document.createElement('li');
        li.innerHTML = `<a href="./manage.php?type=${name}"><i class="${icons[name]}" aria-hidden="true"></i> ${name}</a>`;
        name === page && li.classList.add('active');

        return li;
      });

      for (li of leftNavItems) { 
        ul.appendChild(li);
      }

      elem.appendChild(ul)
    </script>
  </body>
</html> 