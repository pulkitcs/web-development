<?php
  $status = session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['isAuthorized']);
  $userOptions = $status ? '<li>Hi '.$_SESSION['name'].'</li><li class="user-nav-btn"><a href="#">My Account</a></li><li class="user-nav-btn"><a href="/login.php">Sign out</a></li>' : '<li class="user-nav-btn"><a href="/login.php">Sign in</a></li>';
?>
<style>
.user-section {
  display: flex;
  justify-content: flex-end;
  font-size: 1rem;
  list-style-type: none;
  align-items: center;
}

.user-section > li {
  color: var(--white);
  display: block;
  padding:  0 1rem;
  font-weight: 400;
}

.user-section > li.user-nav-btn {
  background-color: var(--bg-light-highlight);
  padding: .4rem .6rem;
  margin-right: .5rem;
  border-radius: 3px;
}

.user-section > li:last-child {
  margin-right: 0;
}

.user-section > li a{
  color: reset;
  text-decoration: none;
}
</style>
<div class="border-bottom dark-gray-bg">
  <ul class="user-section bmb-container">
    <?= $userOptions ?>
  </ul>
</div>