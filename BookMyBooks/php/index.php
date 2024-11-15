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
    <style>
      .content {
        flex-grow: 1;
      }

      .card-container {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
      }

      .book-card {
        display: flex;
        width: 32%;
      }
      
      .book-card > figure {
        width: 230px;
        display: flex;
        justify-content: center;
        border: solid thin var(--background-gray);
        background-color: var(--background-white-smoke);
        padding: 1rem;
      }

      .card-description {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        padding: 1rem;
        border: solid thin var(--background-gray);
        border-left: none;
      }

      .card-description > p {
        margin-bottom: .5rem;
      }

      .card-description > .title {
        font-size: 1.3rem;
      }

      .card-description > .price {
        margin-top: .4rem;
        font-size: 1.7rem;
        display: flex;
        align-items: center;
      }

      .card-description > .category, .card-description > .publisher {
        margin-top: .4rem;
      }

      .card-description > .author {
        margin-top: -.2rem;
      }

      .card-description > .category {

      }

      .discount-info {
        font-size: 1rem;
        padding: .2rem;
      }

      .btn-box {
        margin-top: 1rem;
      }

      .quantity {
        padding: .5rem;
        font-size: 1.2rem;
        width: 3rem;
        background-color: var(--background-cream);
      }

      .btn-box > button {
        padding: .5rem;
        display: inline-block;  
        font-size: 1.2rem;
        border-radius: 5px;
        cursor: pointer;
        align-self: baseline;
        margin: 0 10px;
        background-color: var(--background-cream);
      }

      .filters {
        font-size: 1.2rem;
        margin-left: 1rem;
        /* float: right; */
      }

      .filters form {
        display: inline-block;
      }

      .filters label {
        margin-right: .5rem;
      }

      .filters input {
        margin-right: .2rem;
      }
      
      .filters button, .search-reset {
        margin-left: .5rem;
        padding: .2rem;
      }

      .empty-result {
        font-size: 1.2rem;
      }
    </style>
  </head>
  <body>
    <?php
      require_once("./partials/full-header.php");
    ?>
    <main class="main bmb-container">
    <?php
      require_once("./configs/app-config.php");
      require_once("./classes/Database.php");

      function getSelectedCategory($category) {
        $currentCategory = isset($_GET['category']) ? $_GET['category'] : 'all';
        return $currentCategory === $category ? 'checked' : null;
      }

      $currentCategory = isset($_GET['category']) ? $_GET['category'] : 'all';
      $search = isset($_GET['search']) ? $_GET['search'] : null;

      $db = new Database($appConfig);
      $result = $db->getAllBooks($currentCategory, $search);

      $categories = $db->getCategories();
      $categoryStr = "
        <form name='category-filter' method='get'>";
      
      if($search !== null) 
        $categoryStr.= "<input name='search' type='hidden' value=".$search." />";
          
      $categoryStr .= "<input name='category' id='filter-all' type='radio' value='all' ".getSelectedCategory('all')."/><label for='filter-all'>All</label>";

      for($i=0; $i < sizeof($categories); $i++) {
        $categoryStr.= "<input id='filter-".$categories[$i]['name']."' ".getSelectedCategory($categories[$i]['name'])." name='category' type='radio' value='".$categories[$i]['name']."' /><label for='filter-".$categories[$i]['name']."'>".$categories[$i]['name']."</label>";
      }

      $categoryStr.="<button type='submit'>Apply</button><button type='button' onclick='window.location.href=`./index.php`'>Clear / Reset</button>";
    ?>
    <div class="sub-section">
      <!-- <div class="side-control">
        <p class="side-heading">Filter</p>
      </div> -->
      <div class="content">
        <h1 class="heading">Welcome</h1>
        <p style="font-size: 1.2rem;margin-bottom: 2rem;">At BookMyBooks, we believe in the magic of books. Our mission is to bring the joy of reading to everyone, everywhere. Whether you're a lifelong bookworm or just discovering the wonders of the written word, we have something for you. Scroll through the below list to search a relevant book as per your needs.</p>
  
        <h2 class="sub-heading">Category: <?= isset($_GET['category']) ? $_GET['category'] : 'All' ?> <span class="filters"><?= $categoryStr ?></span></h1>
        <h2 class="sub-heading"><?= isset($_GET['search']) ? "Search: ".$_GET['search']."<button class='search-reset' type='button' onclick='window.location.href=`./index.php`'>Clear / Reset</button>" : null ?></h2>
        <section class="card-container">
          <?php
            function discountedPrice($price, $discount) {
              return $price - ($price * ($discount / 100));
            }

            if($result === null) {
              echo '<p class="empty-result">No Items Found!</p>';
              exit();
            }

            $count = sizeOf($result);

            if($count === 0) echo '<p class="empty-result">No Items Found!</p>';
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
                $stock = $result[$i]['stock'];
                $discount = $result[$i]['discount'];
                //$isInStock = $stock > 0 ? 'In stock' : 'Out of stock';
                $discountPercentage = $discount > 0 ? "<span class='discount-info'>(".$discount."% OFF)</span>" : "";
                $discountedRate = "<span>₹</span>".discountedPrice($price, $discount);
                
                $str.= "<div class='book-card'>
                  <figure>
                    <img src='".$thumbnail."' alt='".$name."' height='250' width='auto' />
                  </figure>
                  <div class='card-description'>
                    <p class='title'>".$name."</p>
                    <p class='author'>by ".$author."</p>
                    <p class='publisher'>".$publisher."</p>
                     <p class='category'>".$category." | ".$publicationYear."</p>
                    <p class='price'>".$discountedRate."".$discountPercentage."</p>
                    <p>Delivery in 3 days</p>
                    <p>Cash on delivery only</p>
                    <p class='btn-box'>
                      <input id='".$ISBN."' class='quantity' type='number' min='0' max='$stock' onchange='checkQuantity(event, `".$ISBN."`)' value='0' required/>
                      <button name='addToCart' type='button' data-book-id='".$ISBN."' disabled onclick='updateCart(event, `".$ISBN."`, `".discountedPrice($price, $discount)."`, `".$name."`, `".$author."`)'>Add To Cart</button>
                    </p>
                  </div>
                </div>";
              }

              echo $str;
            }
          ?>
       </section>
       <script>
          function addToCart(isbn, qty, btn) {

          }

          function updateCart(event, isbn, discountedPrice, title, author) {
            const { target: { previousElementSibling }} = event;
            const { value: quantity } = previousElementSibling;

            fetch('./api/cart.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify({ isbn, title, author, price: discountedPrice, quantity: parseInt(quantity) })
            })
            .then(e => { 
              const { status } = e;
              if(status === 401) window.location.href="./login.php";
              return e.json(); 
            })
            .then(items => {
              alert('Item added, please check your Cart!');
              window.location.reload();
            })
            .catch(e => console.error(e))
          }

          function checkQuantity(event) {
            const { target: { value, nextElementSibling } } = event;
            if(value > 0) {
              nextElementSibling.disabled = false;
            }
            else 
            nextElementSibling.disabled = true;
          }
       </script>
      </div>
    </div>
    </main>
    <?php require_once("./partials/footer.php") ?>
  </body>
</html> 