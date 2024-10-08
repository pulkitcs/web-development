<style>
  header.header {
    background-color: var(--bg-highlight-color);
  }

  .searchAndCart {
    padding: 2.5rem 1rem;
    display: flex;
    justify-content: space-between;
  } 
</style> 
<header class="header">
  <?php require_once("./partials/nav-user.php") ?>
  <div class="dark-gray-bg">
    <div class="searchAndCart bmb-container">
      <?php require_once("./partials/logo.php") ?>
      <?php require_once("./partials/search-cart.php") ?>
    </div>
  <?php require_once("./partials/nav.php") ?>
  </div>
</header>