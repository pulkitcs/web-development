<?php
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
            <th>Admin comments</th>
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
        $admin_comments = $result[$i]['admin_comments'];
  
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
              <th>Qty</th>
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
          $button = "<button type='button' class='edit-link' onclick='openDialog(event, `".$id."`, `".$statusKey."`, `".$delivery_date."`)'><i class='fa fa-pencil' aria-hidden='true'></i> Edit</button>";
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
            <td>".$admin_comments."</td>
            <td>".$button."</td>
          </tr>";
      };
  
      $str .= "</tbody></table>";
    }

    return $str;
  }
?>
<style>
  .table .table thead tr {
    background-color: var(--background-cream) !important;
  }

  .dialog * {
    box-sizing: border-box;
  }

  .dialog h3{
    font-size: 1.7rem;
    font-weight: 400;
    margin-bottom: 1rem;
  }

  .dialog label {
    display: block;
    font-size: 1.1rem;
    margin-bottom: .3rem;
  }

  .dialog select, .dialog input[type=date], .dialog textarea, .dialog button {
    font-size: 1.1rem;
    padding: .5rem;
    display: block;
    width: 100%;
    margin-bottom: 1rem;
  }

  .dialog button {
    display: inline-block;
    width: fit-content;
    margin-right: 1rem;
  }
</style>
<div>
  <!-- <section></section> -->
  <section>
    <h3 style="margin-bottom: 1rem; font-size: 1.2rem; font-weight: 400">All orders are on 'Cash on delivery' only payment mode.</h3>
    <?php
      echo ordersView($db);
    ?>
    <dialog class="dialog">
      <h3>Update Order</h3>
      <label for="upt-order-status">Status</label>
      <select id="upt-order-status" name="upt-order-status">
        <option value='0'>Pending</option>
        <option value='1'>Processing</option>
        <option value='2'>Completed</option>
        <option value='3'>Cancelled</option>
      </select>
      <label for="upt-order-delivery-date">Delivery Date (DD-MM-YYYY)</label>
      <input id="upt-order-delivery-date" type="date">
      <label for="upt-order-admin-comment">Admin Comments</label>
      <textarea id="upt-order-admin-comment">Ok</textarea>
      <button class="dialog-update">Update</button><button class="dialog-close" onclick="dialogClose(event)">Cancel</button>
    </dialog>
  </section>   
</div>
<script>
  Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON()?.slice(0,10);
  });

  function fetchData(url, body) {
    return fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(body)
    });
  }

  function openDialog(e, orderId, status, deliverDate) {
    const dialog = document.querySelector('dialog');
    dialog.showModal();

    const updateBtn = document.querySelector('.dialog-update');
    const orderStatus = document.getElementById('upt-order-status');
    const deliveryDate = document.getElementById('upt-order-delivery-date');
    const adminComment = document.getElementById('upt-order-admin-comment');
    let date;

    if(deliverDate) date = new Date(deliverDate);
    else date = new Date();

    deliveryDate.value = date.toDateInputValue();
    deliveryDate.max = new Date().toISOString().split("T")[0];
    orderStatus.value = status;

    updateBtn.onclick = async function() {
      const reply = fetchData('./api/order.php', { operation: 'update', orderId, data: { status: orderStatus.value, deliveryDate: deliveryDate.value, adminComment: adminComment.innerText }});
      const response = await reply;
      const {ok, status} = response;

      if(ok && status === 200) {
        alert('Order updated successfully');
        window.location.reload();
      } else
        alert('Error occurred, please contact administrator or mail us at pulkitchandra@outlook.com');
    }
  }

  function dialogClose(e) {
    e.target.parentElement.close();
  }

</script>
