<?php 
  require_once("./partials/session.php");
  require_once("./configs/app-config.php");
  require_once("./classes/Database.php");

  $db = new Database($appConfig);

  function ordersView($db) {
    $result = $db -> adminGetOrders();
    $count = sizeof($result);
    
    if($count === 0) return "<p>No Orders Found!</p>";
    else {
      $str = "
      <table class='table' border='0' cellspacing='0' cellpadding='0'>
        <thead>
          <tr>
            <th>#</th>
            <th>Id</th>
            <th>User Details</th>
            <th>Details</th>
            <th>Total Cost</th>
            <th>Order date (YYYY-MM-DD)</th>
            <th>Delivery date (YYYY-MM-DD)</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
      <tbody>";

      for($i = 0; $i < $count; $i++) {
        $id = $result[$i]['id'];
        $user = $result[$i]['user'];
        $address = $result[$i]['address'];
        $mobile = $result[$i]['mobile'];
        $details = $result[$i]['details'];
        $cost = $result[$i]['cost'];
        $order_date = $result[$i]['order_date'];
        $delivery_date = $result[$i]['delivery_date'];
        $statusKey = $result[$i]['status'];
  
        $serialNo = $i + 1;
        $status = '';

        switch($statusKey) {
          case '0': 
            $status = 'Pending';
            break;
          case '1':
            $status = 'Processing';
            break;
          case '2':
            $status = 'Completed';
            break;
          case '3':
            $status = 'Cancelled';
            break;
          default:
            $status = 'Pending';
        }
        
        $cart = json_decode($details);

        $cartData = "<table class='table' border='0' cellspacing='0' cellpadding='0'>
          <thead>
            <tr>
              <th>ISBN</th>
              <th>Title</th>
              <th>Quantity</th>
              <th>₹/Unit</th>
            </tr>
          </thead>
          <tbody>";
        
        $keys = array_keys(get_object_vars($cart));

        for($n = 0; $n < sizeof($keys); $n++) {
          $isbn = $keys[$n];
          $title = $cart->$isbn->title;
          $quantity = $cart->$isbn->quantity;
          $price = $cart->$isbn->price;

          $cartData.="<tr><td>".$isbn."</td><td>".$title."</td><td>".$quantity."</td><td>".$price."</td></tr>";
        }

        $cartData.= "</tbody></table>";

        $button = null;

        if($statusKey === '1' || $statusKey === '0') {
          $button = "<button type='button' class='edit-link' onclick='cancelOrder(event, `".$id."`)'><i class='fa fa-ban' aria-hidden='true'></i> Cancel</button>";
        }

        $str.="
          <tr>
            <td>".$serialNo."</td>
            <td>".$id."</td>
            <td>
              <p>".$_SESSION['name']."</p>
              <p>".$user."</p>
              <p>".$mobile."</p>
              <p>".$address."</p>
            </td>
            <td>".$cartData."</td>
            <td>₹".$cost."</td>
            <td>".$order_date."</td>
            <td>".$delivery_date."</td>
            <td>".$status."</td>
            <td>".$button."</td>
          </tr>";
      };
  
      $str .= "</tbody></table>";
    }

    return $str;
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

      .table .table thead tr {
        background-color: var(--background-cream) !important;
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
          <h1 class="heading">My Orders</h1>
          <h3 style="margin-bottom: 1rem; font-size: 1.2rem; font-weight: 400">All orders are on 'Cash on delivery' only payment mode.</h3>
          <section><?= ordersView($db) ?></section>
        </div>
      </div>
    </main>
    <script>
    function fetchData(url, body) {
      return fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(body)
      });
    }

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
          <p> Quantity(${quantity}) (₹${price} x ${quantity}) = ₹${price * quantity} </p>
        </div>`
      }

      if(dm==='')
        dm=`<div class="cart-line-item">No items in cart</div>`;
      else 
        dm += `<h2 class="weight-normal">Total: ₹${bmb['cart-cost']}</h2>
              <button class="confirm-button" onclick="placeOrder(event)" type="button"><i class="fa fa-check-circle" aria-hidden="true"></i> Place Order</button>`

      parentElem.innerHTML = dm;
    }

    async function placeOrder() {
      const reply = fetchData('./api/order.php', { operation: 'create' });
      const response = await reply;
      const {ok, status} = response;

      if(ok && status === 200) {
        alert('Order placed successfully');
        window.location.reload();
      } else
        alert('Error occurred, please contact administrator or mail us at pulkit.cs@gmail.com');
    }

    function deleteCartItem(e, key) {
      delete window?.bmb?.cart[key];

      fetchData('./api/cart.php?operation=delete', window?.bmb?.cart)
      .then(e => e.json())
      .then(items => {
        alert('Item deleted, please check your Cart!');
        window.location.reload();
      })
      .catch(e => console.error(e))
    }

    async function cancelOrder(e, orderId) {
      const trueOrFalse = window.confirm('Click Ok to proceed');

      if(!trueOrFalse) return;

      const response = await fetchData('./api/order.php', { operation: 'cancel', orderId });
      const {ok, status} = response;

      if(ok && status === 200) {
        alert('Order cancelled!');
        window.location.reload();
      }
    }

    function init() {
      renderCart();
    }
    
    init();
    </script>
    <?php require_once("./partials/footer.php") ?>
  </body>
</html> 