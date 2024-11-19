<?php
  session_start();
  session_unset();

  require_once("./configs/app-config.php");
  require_once("./classes/Database.php");

  $db = new Database($appConfig);

  function doLogin($db) {    
    if(!isset($_POST['username']) || !isset($_POST['password'])) return;
    
    $usrname = $_POST['username'];
    $passowrd = $_POST['password'];

    $isValid = $db->authenticateUser($usrname, $passowrd);
    
    if($isValid) {
      $user = $db->getUser($usrname);
      $_SESSION['isAuthorized'] = 1;
      $_SESSION['isAdmin'] = $user['isAdmin'];
      $_SESSION['isReseller'] = $user['isReseller'];
      $_SESSION['name'] = $user['name'];
      $_SESSION['email'] = $user['email'];

      return "<script>
        const { search = '' } = window.location;
        const [, redirectLink = '/'] = search.split('?redirect=');
        window.location.href= redirectLink;
      </script>";

    } else {
      return '<div class="login-error-message"><strong>[Error] </strong> Incorrect username/password!</div>';
    }
  };

  function doRegister($db) {
    if(!isset($_POST['username'])) return;
    
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $repassword = $_POST['repassword'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $mobile = $_POST['mobile'];

    $isSuccessful = $db->createUser($fullname, $username, $repassword, $address, $country, $mobile);

    if($isSuccessful !== null && sizeof($isSuccessful) === 0) {
      return '<div class="login-success-message"><strong>[Success] </strong>New User Created successfully!</div>
        <script>
          setTimeout(() => {
            window.location.href = "/login.php";
          }, 2000);
        </script>
      ';
    }
    else  return '<div class="login-error-message"><strong>[Error] </strong>Unable to create new user, please contact your administrator.</div>';
  }

  function newUser() {
    return '
    <form name="register" class="form" action="login.php?type=new" method="post">
      <div class="form-box">
      <h2>NEW USER REGISTRATION</h2>
      <h3>ENTER YOUR DETAILS</h3>
        <input name="fullname" type="text" required placeholder="Full Name" />
        <input name="username" type="email" required placeholder="Email as User Name" />
        <input name="password" id="password" type="password" required placeholder="Password" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@_]).{6,}$"/>
        <label for="password">Please user atleast 6 characters, atleast 1 capital, 1 lower case, 1 number and 1 special character "@" or "_". </label> 
        <input name="repassword" type="password" required placeholder="Re-Password" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@_]).{6,}$"/>
        <textarea name="address" required placeholder="Your address"></textarea>
        <select name="country" value="India"><option value="India">India</option></select>
        <input name="mobile" type="text" required placeholder="Mobile Number" pattern="[0-9]{10,10}"/>
        <button class="register_button" type="submit">Register</button>
      </div>
    </form>';
  }

  function login() {
    return '
    <dialog class="login-forgot-password-dialog">
      <p>To reset password please contact the administrator using the email: </p>
      <p><a href="mailto:pulkitchandra@outlook.com">pulkitchandra@outlook.com</a></p>
      <button class="login-exit-dialog">Close</button>
    </dialog>
    <form name="login" class="form" action="/login.php" method="post">
      <div class="form-box">
        <h3>LOGIN WITH YOUR CREDENTIALS</h3>
        <input name="username" type="email" required placeholder="Username" />
        <input name="password" type="password" required placeholder="Password" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@_]).{6,}$"/>
        <button type="submit">Sign In</button>
        <p class="login-help"><a href="./login.php?type=new">New User</a> or <a href="#" class="login-open-dialog">Forgot passoword</a> 
      </div>
    </form>';
  }

  $registerResult = "";
  $loginResult = "";
  
  if(isset($_GET['type']))
    $registerResult = doRegister($db);
  else 
    $loginResult = doLogin($db);
?>
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
      require_once("./partials/font.php");
      require_once("./partials/styles.php");
    ?>
    <style>
      .main {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: rgb(255,255,255);
        background: radial-gradient(circle, rgba(255,255,255,1) 0%, rgba(193,232,153,1) 100%);
        flex-direction: column;
      }

      .form {
        padding: 2rem;
        width: 450px;
        height: auto;
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

      .form-box > input[type=text], .form-box > input[type=password], .form-box > input[type=email], select, textarea {
        box-sizing: content-box;
        display: block;
        padding: .5rem;
        font-size: 1.2rem;
        width: 100%;
        margin-bottom: 1rem;
        border-radius: 5px;
        border: none;
      }
      
      .form-box > button[type=submit] {
        padding: .5rem;
        display: block;  
        font-size: 1.2rem;
        border-radius: 5px;
        cursor: pointer;
        border: none;
      }
      
      h3, h2 {
        align-self: flex-start;
        color: var(--white);
        margin-bottom: 1.5rem;
        font-weight: 400;
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
        color: var(--white);
      }

      .login-header {
        position: fixed;
        background-color: var(--bg-highlight-color);
        width: 100%;
        box-shadow: 0 0 2px 1px #666;
      }

      .login-error-message, .login-success-message {
        font-size: 1.2rem;
        width: 50%;
        padding: .5rem .7rem;
        color: var(--white);
        background-color: var(--bg-red);
        margin-bottom: 2rem;
        border-radius: 3px;
      }

      .login-success-message {
        background-color: var(--bg-highlight-color);
      }

      .login-forgot-password-dialog {
        left: 50%;
        top: 50%;
        width: 300px;
        height: 110px;
        padding: 1rem;
        font-size: 1.2rem;
        margin-left: -164px;
        margin-top: -69px;
      }

      .login-forgot-password-dialog::backdrop {
        background-color: rgb(0 0 0 / 0%);
        transition: display 0.7s allow-discrete, overlay 0.7s allow-discrete, background-color 0.7s;
      }

      .login-forgot-password-dialog[open]::backdrop {
        background-color: rgb(0 0 0 / 60%);
      }

      .login-forgot-password-dialog > p {
        margin-bottom: 1rem;
      }

      label {
        color: var(--white);
        margin: -5px 0 .9rem   0;
      }

      @starting-style {
        .login-forgot-password-dialog[open]::backdrop {
          background-color: rgb(0 0 0 / 0%);
         }
      }
    </style>
  </head>
  <body>
    <header class="login-header">
      <div class="bmb-container">
        <?php require_once("./partials/logo.php"); ?>
      </div>
    </header>
    <main class="main">
      <?= $loginResult ?>
      <?= $registerResult ?>
      <?php
        if(isset($_GET['type'])) {
          if($_GET['type'] === 'new') echo newUser();
            else echo login();
        } else echo login();
      ?>
      <script>
        function init() {
          const registerForm = document.forms['register'];
          const forgotPasswordBtn = document.querySelector('.login-open-dialog');
          const forgotPasswordDialog = document.querySelector('.login-forgot-password-dialog');
          const forgotPasswordCancelDialogBtn = document.querySelector('.login-exit-dialog');

          function showRegisterDialog() {
            forgotPasswordBtn?.addEventListener('click', () => forgotPasswordDialog.showModal());
            forgotPasswordCancelDialogBtn?.addEventListener('click', () => forgotPasswordDialog.close());
          }

          function checkPassword() {
            registerForm?.addEventListener('submit', (e) => {
              const isPasswordMatching = registerForm['password'].value === registerForm['repassword'].value;

              if(!isPasswordMatching) {
                e.preventDefault();
                alert('[Error] The field password and re-password donot match, please enter the same value');
              }

              return isPasswordMatching;
            });
          }

          showRegisterDialog();
          checkPassword();
        }

        init();
      </script>
    </main>
    <?php require_once("./partials/footer.php"); ?>
  </body>
</html> 