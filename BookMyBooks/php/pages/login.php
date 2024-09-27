<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Online store for purchasing books">
    <meta name="keywords" content="ONLINE,BOOKS,STORE,LEARNING">
    <meta name="author" content="pulkit.cs@gmail.com">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login to BookMyBooks</title>
    <?php
      require_once("../partials/font.php");
      require_once("../partials/styles.php");
    ?>
    <style>
      .main {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: rgb(255,255,255);
        background: radial-gradient(circle, rgba(255,255,255,1) 0%, rgba(193,232,153,1) 100%);
      }

      .form {
        padding: 2rem;
        width: 450px;
        height: 300px;
        background-color: var(--bg-highlight-color);
        border-radius: 10px;
        box-shadow: 0 0 10px 5px #ccc;
      }

      .form-box {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
      }

      .logo {
        margin-bottom: 2rem;
      }

      .form-box > input[type=password], .form-box > input[type=email] {
        display: block;
        padding: .5rem;
        font-size: 1.2rem;
        width: 100%;
        margin-bottom: 1rem;
        border-radius: 5px;
      } 

      .form-box > button[type=submit] {
        padding: .5rem;
        display: block;  
        font-size: 1.2rem;
        border-radius: 5px;
        cursor: pointer;
      }

      .form-box > h3 {
        text-align: left;
        color: var(--white);
        margin-bottom: 1.5rem;
      }

      .footer {
        position: fixed;
        bottom: 0;
        width: 100%;
      }

      .login-help {
        margin-top: 1rem;
      }

      .login-help > a {
        text-decoration: none;
      }

    </style>
  </head>
  <body>
    <main class="main">
      <form class="form" action="/pages/login.php" method="post">
        <div class="form-box">
          <?php require_once("../partials/logo.php"); ?>
          <h3>Login with your credentials</h3>
          <input type="email" required placeholder="Username" />
          <input type="password" required placeholder="Password" />
          <button type="submit">Sign In</button>
          <p class="login-help"><a href="./login.php?type=new">New User</a> or <a href="./login.php?type=forgot">Forgot passoword</a> 
        </div>
      </form>
    </main>
    <?php require_once("../partials/footer.php"); ?>
  </body>
</html> 