<?php
  require_once("./configs/app-config.php");
  require_once("./classes/Database.php");

  $db = new Database($appConfig);

  function getOrders($db, $isAdmin) {

  }

  function ordersView($db) {
    $result = $db -> adminGetOrders();
    $count = sizeof($result);

    if(sizeof($result) === 0) return "<p>No Orders Found!</p>";
    else {
      $str = "
      <table class='table' border='0' cellspacing='0' cellpadding='0'>
        <thead>
          <tr>
            <th>SNo.</th>
            <th>Id</th>
            <th>User</th>
            <th>Delivery Address</th>
            <th>Details</th>
            <th>Total Cost</th>
            <th>Order date</th>
            <th>Delivery date</th>
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
        $details = $result[$i]['details'];
        $cost = $result[$i]['cost'];
        $order_date = $result[$i]['order_date'];
        $delivery_date = $result[$i]['delivery_date'];
        $status = $result[$i]['status'];
        $admin_comments = $result[$i]['admin_comments'];
  
        $serialNo = $i + 1;
        $status = '';

        switch($status) {
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
              <th>Author</th>
              <th>Quantity</th>
              <th>Price/Unit</th>
            </tr>
          </thead>
          <tbody>";
        
        $keys = array_keys(get_object_vars($cart));

        for($i = 0; $i < sizeof($keys); $i++) {
          $isbn = $keys[$i];
          $title = $cart->$isbn->title;
          $author = $cart->$isbn->author;
          $quantity = $cart->$isbn->quantity;
          $price = $cart->$isbn->price;

          $cartData.="<tr><td>".$isbn."</td><td>".$title."</td><td>".$author."</td><td>".$quantity."</td><td>".$price."</td></tr>";
        }

        $cartData.= "</tbody></table>";

        $str.="
          <tr>
            <td>".$serialNo."</td>
            <td>".$id."</td>
            <td>".$user."</td>
            <td>".$address."</td>
            <td>".$cartData."</td>
            <td>".$cost."</td>
            <td>".$order_date."</td>
            <td>".$delivery_date."</td>
            <td>".$status."</td>
            <td>".$admin_comments."</td>
            <td><button type='button' class='edit-link'><i class='fa fa-pencil' aria-hidden='true'></i> Edit</button></td>
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
</style>
<div>
  <!-- <section></section> -->
  <section>
    <?php
      echo ordersView($db);
    ?>
  </section>   
</div>
