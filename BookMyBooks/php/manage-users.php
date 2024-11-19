<?php
  require_once("./configs/app-config.php");
  require_once("./classes/Database.php");

  $db = new Database($appConfig);
  $read = "";
  $edit = "";
  $create = "";

  function checkSelect($actualValue, $value) {
    return $actualValue === $value ? "selected" : "";
  }

  function checkChecked($isAdmin, $isReseller, $value) {
    if($value === '0')
      return $isReseller === '0' ? $isAdmin === '0' ? 'checked' : '' : '';
    else if($value === '1')
      return $isReseller === '0' ? $isAdmin === '1' ? 'checked' : '' : '';
    else if($value === '2')
      return $isReseller === '1' ? 'checked' : '';
  }

  function editUser($db) {
    $result = $db -> getUser($_GET['id']);

    return '
    <h2>('.$_GET['id'].')</h2>
    <form name="edit_user" class="form" action="./manage.php?type=users" method="post">
      <div class="form-box">
        <input name="name" type="text" required placeholder="Full Name" value="'.$result['name'].'"/>
        <input name="id" type="hidden" value="'.$result['email'].'"/>
        <input name="email" type="email" required placeholder="Email as User Name" value="'.$result['email'].'"/>
        <input name="password" id="password" type="password" required placeholder="Password" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@_]).{6,}$" value="'.$result['password'].'"/>
        <label for="password">Please user atleast 6 characters, atleast 1 capital, 1 lower case, 1 number and 1 special character "@" or "_". </label> 
        <input name="repassword" type="password" required placeholder="Re-Password" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@_]).{6,}$" value="'.$result['password'].'"/>
        <textarea name="address" required placeholder="Your address">'.$result['address'].'</textarea>
        <select name="country"><option value="'.$result['country'].'">'.$result['country'].'</option></select>
        <input name="mobile" type="text" required placeholder="Mobile Number" pattern="[0-9]{10,10}" value="'.$result['mobile'].'"/>
          <span class="user-selection">
          User Type: <input type="radio" name="user-type" value="0" '.checkChecked($result['isAdmin'], $result['isReseller'], '0').'> Normal 
            <input type="radio" name="user-type" value="1" '.checkChecked($result['isAdmin'], $result['isReseller'], '1').'> Admin 
            <input type="radio" name="user-type" value="2" '.checkChecked($result['isAdmin'], $result['isReseller'], '2').'> Reseller
        </span>
        <select name="disabled" required>
          <option value="1" '.checkSelect($result['disabled'], "1").'>Disabled</option>
          <option value="0" '.checkSelect($result['disabled'], "0").'>Enabled</option>
        </select>
        <textarea name="admin_comments" placeholder="Admin comments">'.$result['admin_comments'].'</textarea>
        <button class="update" type="submit">Update</button>
      </div>
    </form>';
  }

  function newUser() {
    return '
    <h2>Create a User</h2>
    <form name="create_user" class="form" action="./manage.php?type=users" method="post">
      <div class="form-box">
        <input name="name" type="text" required placeholder="Full Name"/>
        <input name="email" type="email" required placeholder="Email as User Name"/>
        <input name="password" id="password" type="password" required placeholder="Password" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@_]).{6,}$" />
        <label for="password">Please user atleast 6 characters, atleast 1 capital, 1 lower case, 1 number and 1 special character "@" or "_". </label> 
        <input name="repassword" type="password" required placeholder="Re-Password" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@_]).{6,}$" />
        <textarea name="address" required placeholder="Your address"></textarea>
        <select name="country" required><option value="India">India</option></select>
        <input name="mobile" type="text" required placeholder="Mobile Number" pattern="[0-9]{10,10}" />
        <span class="user-selection">
          User Type: <input type="radio" name="user-type" value="0" checked> Normal <input type="radio" name="user-type" value="1"> Admin <input type="radio" name="user-type" value="2"> Reseller
        </span>
        <select name="disabled" required>
          <option value="0">Enabled</option>
          <option value="1">Disabled</option>
        </select>
        <textarea name="admin_comments" placeholder="Admin comments"></textarea>
        <button class="update" type="submit">Create</button>
      </div>
    </form>';
  }


  function updateUser($db) {
    $id = $_POST['id'];
    $fullname = $_POST['name'];
    $username = $_POST['email'];
    $repassword = $_POST['repassword'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $mobile = $_POST['mobile'];
    $userType = $_POST['user-type'];
    $disabled = $_POST['disabled'];
    $comments = $_POST['admin_comments'];
    $isAdmin = '0';
    $isReseller = '0';

    if($userType === '2') {
      $isAdmin = '0';
      $isReseller = '1';
    } else if($userType === '1') {
      $isAdmin = '1';
      $isReseller = '0';
    } else {
       $isAdmin = '0';
      $isReseller = '0';
    }

    $db -> adminUpdateUser($id, $fullname, $username, $repassword, $address, $country, $mobile, $isAdmin, $isReseller, $disabled, $comments);
  }

  function createUser($db) {
    $fullname = $_POST['name'];
    $username = $_POST['email'];
    $repassword = $_POST['repassword'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $mobile = $_POST['mobile'];
    $userType = $_POST['user-type'];
    $disabled = $_POST['disabled'];
    $comments = $_POST['admin_comments'];
    $isAdmin = '0';
    $isReseller = '0';

    if($userType === '2') {
      $isAdmin = '0';
      $isReseller = '1';
    } else if($userType === '1') {
      $isAdmin = '1';
      $isReseller = '0';
    } else {
       $isAdmin = '0';
      $isReseller = '0';
    }

    $db -> adminCreateUser($fullname, $username, $repassword, $address, $country, $mobile, $isAdmin, $isReseller, $disabled, $comments);
  }

  function getAllUsers($db) {
    if(isset($_POST['email']) && isset($_POST['id']))
      updateUser($db);
    else if(isset($_POST['email']))
      createUser($db);
    else;

    $result = $db->getAllUsers();
    $count = sizeOf($result);
    $read = "";

    if($count === 0) return '<p>No Items Found </p>';
    else {
      $read = "
      <a class='button' href='./manage.php?type=users&mode=create'>Add User</a>
      <table class='table' border='0' cellspacing='0' cellpadding='0'>
        <thead>
          <tr> 
            <th>SNo.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Country</th>
            <th>Mobile</th>
            <th>Address</th>
            <th>Disabled</th>
            <th>Is Admin</th>
            <th>Is Reseller</th>
            <th>Admin Comments</th>
            <th></th>
          </tr>
        </thead>
        <tbody>";
  
      for($i = 0; $i < $count; $i++) {
        $name = $result[$i]['name'];
        $email = $result[$i]['email'];
        $country = $result[$i]['country'];
        $mobile = $result[$i]['mobile'];
        $address = $result[$i]['address'];
        $disabled = $result[$i]['disabled'];
        $isAdmin = $result[$i]['isAdmin'];
        $isReseller = $result[$i]['isReseller'];
        $admin_comments = $result[$i]['admin_comments'];
  
        $serialNo = $i + 1;
        $disabled_state = $disabled === '0' ? 'false' : 'true';
        $admin_state = $isAdmin === '0' ?  'false' : 'true';
        $reseller_state = $isReseller === '0' ?  'false' : 'true';
  
        $read.="
          <tr>
            <td>".$serialNo."</td>
            <td>".$name."</td>
            <td>".$email."</td>
            <td>".$country."</td>
            <td>".$mobile."</td>
            <td>".$address."</td>
            <td>".$disabled_state."</td>
            <td>".$admin_state."</td>
            <td>".$reseller_state."</td>
            <td>".$admin_comments."</td>
            <td><a class='edit-link' href='./manage.php?type=users&mode=edit&id=".$email."'><i class='fa fa-pencil' aria-hidden='true'></i> Edit</a></td>
          </tr>";
      };
      $read .= "</tbody></table>";
    }

    return $read;
  }

  if(isset($_GET['mode']) && isset($_GET['id']))
    $edit = editUser($db);
  else if (isset($_GET['mode']))
    if($_GET['mode']==='create')
      $create = newUser();
    else;
  else $read = getAllUsers($db);
?>
<style>
  h2 {
    margin-top: 1rem;
    font-weight: 400;
    margin-bottom: 20px;
  }

  .form-box {
    width: 500px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin: 0 .7rem;
  }

  .form-box > input[type=text], .form-box > input[type=password], .form-box > input[type=email], .form-box select, .form-box textarea {
    box-sizing: content-box;
    display: block;
    padding: .5rem;
    font-size: 1.2rem;
    width: 100%;
    margin-bottom: 1rem;
    border-radius: 5px;
    /* border: none; */
  }

  .form-box > button[type=submit] {
    padding: .5rem;
    display: block;  
    font-size: 1.2rem;
    border-radius: 5px;
    cursor: pointer;
    align-self: baseline;
    margin-left: -.6rem;
    /* border: none; */
  }

  label {
    margin: -5px 0 .9rem   0;
  }

  .button {
    background-color: var(--background-cream);
    text-decoration: none;
    padding: .5rem;
    border-radius: 5px;
    border: solid thin var(--background-gray);
  }

  .table {
    margin-top: 1.5rem;
  }

  .user-selection {
    box-sizing: border-box;
    font-size: 1.2rem;
    padding: 1rem;
    display: inline-block;
    width: 100%;
    border: solid thin var(--background-gray);
    border-radius: 5px;
    margin-bottom: 1rem;
  }
</style>
<div>
  <!-- <section></section> -->
  <section>
    <?php
      if(isset($_GET['mode'])) {
        if($_GET['mode'] === 'edit')
          echo $edit;
        else if ($_GET['mode'] === 'create')
          echo $create;
        else
          echo $read;
      }
      else 
        echo $read;
    ?>
  </section>   
</div>
<script>
  function init() {
    const editUser = document.forms['edit_user'];
    const createUser = document.forms['create_user'];

      function checkPassword(elem) {
        elem?.addEventListener('submit', (e) => {
        const isPasswordMatching = elem['password'].value === elem['repassword'].value;

        if(!isPasswordMatching) {
          e.preventDefault();
          alert('[Error] The field password and re-password donot match, please enter the same value');
        }

        return isPasswordMatching;
      });
    }

    checkPassword(editUser);
    checkPassword(createUser);
  }

  init();
</script>