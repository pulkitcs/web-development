<style>
.user-section {
  display: flex;
  justify-content: flex-end;
  font-size: 1rem;
  list-style-type: none;
}

.user-section > li {
  display: block;
  padding:  0 1rem;
  font-weight: 400;
}

.user-section > li:last-child {
  padding-right: 0;
  border-left: solid thin var(--background-gray-bg);
}

.user-section > li a{
  color: var(--white);
  text-decoration: none;
}

.user-section > li a:hover, .user-section > li a:focus {
  color: var(--white);
  text-decoration: underline;
}
</style>
<div class="border-bottom dark-gray-bg">
  <ul class="user-section container">
    <li><a href="/pages/login.php">Sign in</a></li>
    <li><a href="#">My Account</a></li>
  </ul>
</div>