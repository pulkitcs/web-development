<?php 
  require_once("./configs/app-config.php");
  require_once("./classes/Database.php");

  $db = new Database($appConfig);

  function getCategories($db) {
    $result = $db->getCategories();
    $string = '<select name="category" class="choose"><option value="all">All</option>';
  
    for($i=0; $i < count($result); ++$i) {
      $name = $result[$i]['name'];
      $string = $string."<option value=".$name.">".$name."</option>";
    }

    return $string.'</select>';
  }

  function getCartDetails($db) {
    if(isset($_SESSION['email'])) {
      return $db->getCart($_SESSION['email'])['cart'];
    } else return array();
  }

  $search = isset($_GET['search']) ? $_GET['search'] : null; 
?>
<style>
.search {
  display: flex;
  height: 3rem;
}

.choose {
  /* -moz-appearance:none;
  -webkit-appearance: none; 
  appearance: none; */
  padding: .5rem .5rem;
  font-size: 1.2rem;
  line-height: 1.8rem;
  background-color: var(--background-cream);
  width: 150px;
  border: none;
  outline: none;
  border: solid thin var(--background-cream);;
}

.search-box {
  -moz-appearance:none;
  -webkit-appearance: none; 
  appearance: none;
  padding: .7rem 1rem;
  font-size: 1.2rem;
  line-height: 1.8rem;
  background-color: var(--background-white-smoke);
  border: none;
  width: 40vw;
  outline: none;
  border: solid thin var(--background-gray);;
}

.search-submit {
  border: none;
  background-color: var(--bg-light-highlight);
  cursor: pointer;
  padding: 1rem;
  display: flex;
  justify-content: center;
  align-items: center;
  /* appearance: none;
  -moz-appearance: none;
  -webkit-appearance: none; */
}

.search-submit > i {
  color: var(--color-black);
  font-size: 1.2rem;
}

.search-cart {
  display: flex;
}

.search-cart-button {
  display: flex;
  border: none;
  background-color: var(--bg-light-highlight);
  cursor: pointer;
  height: 3rem;
  margin-left: 3rem;
  font-weight: 400;
  text-decoration: none;
}

.search-cart-button > i {
  padding: 1rem;
  font-size: 1.2rem;
}

.search-cart-button > span {
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 0 1rem;
  background-color: var(--bg-highlight-color);
  color: var(--white);
  font-weight: 600;
}

.search-cart-button span  {
  text-align: left;
}
</style>

<div class="search-cart">
  <form class="search" method="get">
    <?= getCategories($db) ?>
    <input type="text" name="search" class="search-box" placeholder="Enter keywords to search.." value="<?=$search?>"/>
    <button class="search-submit" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
  </form>
  <a href="./cart.php" class="search-cart-button">
    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
    <span>
      <span>SHOPPING CART</span>
      <span id="cart-cost">₹0</span>
    </span>
  </a>
</div>
<script>
  function updateCartIcon() {
    window.bmb = {};
    const elem = document.getElementById('cart-cost');
    window.bmb['cart'] = JSON.parse(<?= json_encode(getCartDetails($db)) ?>) || {};

    const {cart} = window.bmb;
    const priceList = [];

    for(let i in cart) {
      const {price, quantity}  = cart[i];
      priceList.push({price, quantity});
    }

    const cost = priceList.reduce((agg, { price, quantity }) => (agg + (price*quantity)), 0);
    elem.innerHTML = `₹${cost}`;
    window.bmb['cart-cost'] = cost;
  }

  updateCartIcon();
</script>