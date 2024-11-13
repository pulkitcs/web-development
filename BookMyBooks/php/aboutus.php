<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Online store for purchasing books">
    <meta name="keywords" content="ONLINE,BOOKS,STORE,LEARNING">
    <meta name="author" content="pulkit.cs@gmail.com">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BookMyBooks - About Us</title>
    <?php
      require_once("./partials/font.php");
      require_once("./partials/styles.php");
    ?>
    <style>
      .main.bmb-container h1 {
        padding-top: 2rem;
        font-weight: 400;
        margin-bottom: 1.6rem;
      }

      .main.bmb-container h2 {
        font-weight: 400;
        margin-bottom: 1rem;
      }

      .main.bmb-container p, .main.bmb-container ul.items,  .main.bmb-container div {
        font-size: 1.2rem;
        line-height: 1.6rem;
        margin-bottom: 1.4rem;
      }

      .main.bmb-container ul.items li{
        margin-left: 1.5rem;
        margin-bottom: .6rem;
      }
    </style>
  </head>
  <body>
    <?php
      require_once("./partials/full-header.php");
    ?>
    <main class="bmb-container main">
    <h1>Welcome to <strong>BookMyBooks</strong></h1>
    <p>At <strong>BookMyBooks</strong>, we believe in the magic of books. Our mission is to bring the joy of reading to everyone, everywhere. Whether you're a lifelong bookworm or just discovering the wonders of the written word, we have something for you.
    </p>
    <h2>Our Story</h2>
    <p>Founded in 2024, <strong>BookMyBooks</strong> started as a small passion project. Our founder, Navin Chandra &  Pulkit Chandra, were driven by their love for literature and a desire to make books accessible to all. What began as a modest collection of handpicked titles has grown into a vast online library, offering a diverse range of genres and authors from around the world.</p>
    <h2>What We Offer</h2>
    <ul class="items">
      <li><strong>Wide Selection: </strong>From bestsellers to hidden gems, our catalog includes thousands of titles across various genres, including fiction, non-fiction, children's books, and more.</li>
      <li><strong>Curated Collections: </strong>Our team of book enthusiasts curates special collections to help you discover new favorites and timeless classics.</l1>
      <li><strong>Community Focus: </strong>We host virtual book clubs, author events, and reading challenges to foster a vibrant community of readers.</l1>
      <li><strong>Convenient Shopping: </strong>With user-friendly navigation and secure checkout, finding and purchasing your next great read is a breeze.</l1>
    </ul>
    <h2>Our Commitment</h2>
    <p>At <strong>BookMyBooks</strong>, we are committed to promoting literacy and a love for reading. We partner with local schools and libraries to support reading programs and donate books to those in need. Our goal is to create a world where everyone has the opportunity to experience the transformative power of books.</p>
    <h2>Join Us</h2>
    <p>We invite you to explore our collection, join our community, and embark on countless literary adventures. Thank you for choosing <strong>BookMyBooks</strong> as your trusted source for books.</p>
    
    <div>Feel free to customize this content to better fit your bookstore's unique story and offerings! If you need any more help, just let me know.</div>
    </main>
    <?php require_once("./partials/footer.php") ?>
  </body>
</html> 