<?php
  require_once("./partials/session.php");
  require_once("./configs/app-config.php");
  require_once("./classes/Database.php");

  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");

  $db = new Database($appConfig);

  $result = $db->getUser($_SESSION['email']);
  $view = "";

  function userView($result) {
    $name = $result['name'];
    $email = $result['email'];
    $address = $result['address'];
    $country = $result['country'];
    $mobile = $result['mobile'];


    return 
      "<p><strong>Name:</strong> ".$name."</p>
      <p><strong>Email:</strong> <a href='mailto:".$email."'>".$email."</a></p>
      <p><strong>Address:</strong> ".$address."</p>
      <p><strong>Country:</strong> ".$country."</p>
      <p><strong>Mobile:</strong> ".$mobile."</p>
      <button class='edit-button' type='button' style='margin-right: 1rem' onclick='window.location.reload()'><i class='fa fa-refresh' aria-hidden='true'></i> Refresh</button><a class='edit-button' href='./profile.php?mode=edit'><i class='fa fa-pencil' aria-hidden='true'></i> Edit current details</a>";
  }

  function userEditView($result) {
    $name = $result['name'];
    $email = $result['email'];
    $address = $result['address'];
    $country = $result['country'];
    $mobile = $result['mobile'];


    return 
      "
      <form class='profile-edit' name='profile' action='./profile.php' method='post'>
        <p><strong>Name:</strong> <input name='name' value='".$name."' required /></p>
        <p><strong>Email:</strong> <a href='mailto:".$email."'>".$email."</a> (Contact administrator)</p>
        <p><strong>Address:</strong> <textarea name='address' required>".$address."</textarea></p>
        <p><strong>Country:</strong> ".$country."</p>
        <p><strong>Mobile:</strong> <input name='mobile' type='text' value='".$mobile."' pattern='[0-9]{10,10}' required/></p>
        <a class='edit-button' href='./profile.php'><i class='fa fa-ban' aria-hidden='true'></i> Cancel</a>
        <button class='edit-button' type='submit'><i class='fa fa-check' aria-hidden='true'></i> Confirm and Submit</button>
      </form>
      ";
  }

  if(isset($_POST['name'])) {
    $email = $_SESSION['email'];
    $name =  $_POST['name'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];

    $db->updateUser($_SESSION['email'], $name, $address, $mobile);
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Online store for purchasing books">
    <meta name="keywords" content="ONLINE,BOOKS,STORE,LEARNING">
    <meta name="author" content="pulkit.cs@gmail.com">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT"/>
    <meta http-equiv="pragma" content="no-cache" />
    <title>BookMyBooks - Profile Page</title>
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

      .margin {
        margin-bottom: 1.5rem;
      }

      .page-heading {
        font-size: 2.5rem;
        margin-bottom: 2rem;
        font-weight: 400;
      }

      .profile-details {
        font-size: 1.2rem;
        line-height: 1.8rem;
        margin-bottom: 2rem;
      }

      .profile-details strong {
        display: inline-block;
        width: 60px;
        margin-right: 2rem;
      }

      .edit-button {
        font-size: 1.2rem;
        line-height: 1.8rem;
        display: inline-block;
        margin-top: 2rem;
        background-color: var(--background-cream);
        text-decoration: none;
        padding: .5rem;
        border-radius: 5px;
        border: solid thin var(--background-gray);
      }

      form.profile-edit input, form.profile-edit textarea{
        padding: .3rem;
        font-size: 1.1rem;
      }

      form.profile-edit p {
        margin: 0 0 1rem 0;
      }
    </style>
  </head>
  <body>
    <?php
      require_once("./partials/full-header.php");
    ?>
    <main class="bmb-container main">
      <div class="sub-section">
        <nav class="nav side-control">
          <p class="side-heading">Navigate To</p>
          <ul>
            <li><a href="./cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i> My Cart and Orders</a></li>
          </ul>
        </nav>
        <section>
          <h1 class="page-heading">My Profile</h1>
          <h2 class="heading">Edit your profile details</h2>
          <div class="profile-details">
            <?php
             if(isset($_GET['mode']))
                echo userEditView($result);
              else
                echo userView($result);
             ?>
          </div>
        </section>
      </div>
    </main>
    <?php require_once("./partials/footer.php") ?>
  </body>
</html> 