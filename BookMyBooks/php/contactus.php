<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Online store for purchasing books">
    <meta name="keywords" content="ONLINE,BOOKS,STORE,LEARNING">
    <meta name="author" content="pulkit.cs@gmail.com">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BookMyBooks - Contact Us</title>
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
        margin-bottom: 2.5rem;
      }

      .main.bmb-container div  {
        margin-top: 3rem;
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
      <h1>Contact Us</h1>
      <p>At <strong>BookMyBooks</strong>,  we're here to help you with all your book-related needs. Whether you have a question about an order, need a book recommendation, or just want to share your love for reading, we're always happy to hear from you.</p>
      <h2>Get in Touch</h2>
      <ul class="items">
        <li><strong>Email:</strong> Reach out to us at <a href="mailto:pulkitchandra89@gmail.com">pulkitchandra89@gmail.com</a> for any inquiries or support. We strive to respond within 24 hours.</li>
        <li><strong>Phone:</strong> Call us at <a href="tel:+91-9999999999">+91-9999999999</a> between 9am - 6pm for immediate assistance.</li>
        <li><strong>Social Media:</strong> Connect with us on Whatsapp for the latest updates, book recommendations, and more.</li>
      </ul>
      <h2>Visit Us</h2>
      <p style="margin-bottom: 1rem">If you're in the area, feel free to visit our physical store at:</p>
      <address style="font-size: 1.4rem; white-space: break-spaces">
        BookMyBooks
        C-10, Sector 18,
        Noida - 201301
        Uttar Pradesh
        India
      </address>
      <p>We'd love to meet you in person and help you find your next great read.</p>
      <h2>Feedback</h2>
      <p>Your feedback is invaluable to us. Please let us know how we can improve your experience or if there's something specific you'd like to see in our store. Please reach out to us at <a href="mailto:pulkitchandra89@gmail.com">pulkitchandra89@gmail.com</a> for any specific feedback or suggestion</p>

      <h2>Stay Connected</h2>
      <p>Sign up for our newsletter to stay updated on new arrivals, special offers, and upcoming events. Please reach out to us at <a href="mailto:pulkitchandra89@gmail.com">pulkitchandra89@gmail.com</a> and mention "Newsletter" as subject.</p>
    </main>
    <?php require_once("./partials/footer.php") ?>
  </body>
</html> 