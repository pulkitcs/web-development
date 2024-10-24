<?php 
  require_once("./partials/session.php");
  require_once("./configs/app-config.php");
  require_once("./classes/Database.php");
?>
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
      .side-control {
        padding: .5rem;
        background-color: var(--background-cream);
        border: solid thin var(--background-gray);
      }

      .content {
        flex-grow: 1;
      }

      .cart-line-item {
        font-size: 1.1rem;
        margin-bottom: 1rem;
      }

      .cart-line-item > p {
        margin-bottom: .3rem;
      }

      .confirm-button {
        padding: .5rem;
        display: inline-block;
        font-size: 1rem;
        border-radius: 5px;
        cursor: pointer;
        align-self: baseline;
        margin: 1.7rem 0 .5rem 0;
      }
    </style> 
  </head>
  <body>
    <?php
      require_once("./partials/full-header.php");
    ?>
    <main class="main bmb-container">
      <div class="sub-section">
      <div class="side-control">
        <h1 class="heading">Cart</h1>
        <aside class="cart-details"></aside>
      </div>
        <div class="content">
          <h1 class="heading">Orders</h1>
        </div>
      </div>
    </main>
    <script>
    function renderCart() {
      const parentElem = document.querySelector('.cart-details');
      const cart = bmb?.cart || {};
      let dm = '';

      for(let i in cart) {
        const { title, price, quantity } = cart[i];
        dm += `<div class="cart-line-item">
          <p class="title">${title} <button onclick="deleteCartItem(event, '${i}')" style="margin-left: 5px;cursor:pointer;padding: 0 5px">
              Delete <i class="fa fa-trash" aria-hidden="true" style="margin-left: 2px;"></i>
            </button>
          </p>
          <p> Quantity(2) (₹${price} x 2) = ₹${price * 2} </p>
        </div>`
      }

      if(dm==='')
        dm=`<div class="cart-line-item">No items in cart</div>`;
      else 
        dm += `<h2 class="weight-normal">Total: ₹${bmb['cart-cost']}</h2>
              <button class="confirm-button" type="button"><i class="fa fa-check-circle" aria-hidden="true"></i> Place Order</button>`

      parentElem.innerHTML = dm;
    }

    function deleteCartItem(e, key) {
      delete window?.bmb?.cart[key];

      fetch('./api/cart.php?operation=delete', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(window?.bmb?.cart)
      })
      .then(e => e.json())
      .then(items => {
        alert('Item deleted, please check your Cart!');
        window.location.reload();
      })
      .catch(e => console.error(e))
    }

    function init() {
      renderCart();
    }
    
    init();
    </script>
    <?php require_once("./partials/footer.php") ?>
  </body>
</html> 