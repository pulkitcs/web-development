<?php
  require_once("./configs/app-config.php");
  require_once("./classes/Database.php");

  $db = new Database($appConfig);
  $list = "";
  $create = "";
  $edit = "";

  function createBook() {

  }
   
  function checkOption($value, $option) {
    return $value === $option ? "selected" : "";
  }

  function editBook($db) {
    $ISBN = $_GET["id"];
    $result = $db->adminGetBookDetails($ISBN);
    $categories = $db->adminGetCategories();

    $ISBN = $result['ISBN'];
    $title = $result['name'];
    $price = $result['price'];
    $author = $result['author'];
    $publisher = $result['publisher'];
    $publication_year = $result['publication_year'];
    $language = $result['language'];
    $category = $result['category'];
    $thumbnail = $result['thumbnail'];
    $isDisabled = $result['disabled'];
    $stock = $result['stock'];
    $discount = $result['discount'];
    $categoryStr = "";

    for($i=0; $i < sizeof($categories); ++$i) {
      $categoryStr.="<option value='".$categories[$i]['name']."' ".checkOption($category, $categories[$i]['name']).">".$categories[$i]['name']."</option>";
    }

    return'
    <h2>('.$title.')</h2>
    <form name="edit_book" class="form" action="./manage.php?type=books" method="post">
      <div class="form-box">
        <input name="ISBN" type="text" required placeholder="ISBN" value="'.$ISBN.'" title="ISBN"/>
        <input name="id" type="hidden" value="'.$ISBN.'"/>
        <input name="title" type="text" required placeholder="Title" value="'.$title.'" title="Title" />
        <input name="price" type="number" required placeholder="Price" value="'.$price.'" title="Price" />
        <input name="author" type="text" required placeholder="Author" value="'.$author.'" title="Author" />
        <input name="publisher" type="text" required placeholder="Publisher" value="'.$publisher.'" title="Publisher" />
        <input name="publication-year" type="number" required placeholder="Publication Year" value="'.$publication_year.'" title="Publication Year"/>
        <input name="language" type="text" required placeholder="Language" value="'.$language.'" title="Language"/>
        <select name="category" title="Category">'.$categoryStr.'</select>
        <img src="'.$thumbnail.'" alt="'.$title.'" />
        <input name="thumbnail" type="file" required placeholder="Thumbnail Image" title="Thumbnail Image" accept="image/bmp, image/jpeg, image/png, image/gif"/>
        <select name="disabled" title="Is disabled?">
          <option value="0" '.checkOption($isDisabled, "0").'>Enabled</option>
          <option value="1" '.checkOption($isDisabled, "1").'>Disabled</option>
        </select>
        <input name="stock" type="number" required placeholder="Current Stock" value="'.$stock.'" title="Current stock quantity"/>
        <input name="discount" type="number" required placeholder="Discount" value="'.$discount.'" title="Discount"/>
        <button class="update" type="submit">Update</button>
      </div>
    </form>';
  }

  function updateBookDetails($db) {

  }

  function listBooks($db) {
    if(isset($_POST['id']))
      updateBookDetails($db);
    else if(isset($_POST['id']))
      addBook($db);
    else;

    $result = $db->adminGetAllBooks();
    $count = sizeOf($result);
  
    if($count === 0) echo '<p>No Items Found </p>';
    else {
      $str = "
      <a class='button' href='./manage.php?type=books&mode=create'>Add Book</a>
      <table class='table' border='0' cellspacing='0' cellpadding='0'>
        <thead>
          <tr>
            <th>SNo.</th>
            <th>Image</th>
            <th>ISBN</th>
            <th>Book Title</th>
            <th>Category</th>
            <th>Author</th>
            <th>Language</th>
            <th>Publisher</th>
            <th>Publication Yr.</th>
            <th>Stock</th>
            <th>Discount</th>
            <th>Actual Price</th>
            <th>Disabled</th>
            <th></th>
          </tr>
        </thead>
        <tbody>";
  
      for($i = 0; $i < $count; $i++) {
        $ISBN = $result[$i]['ISBN'];
        $title = $result[$i]['name'];
        $price = $result[$i]['price'];
        $author = $result[$i]['author'];
        $publisher = $result[$i]['publisher'];
        $publicationYear = $result[$i]['publication_year'];
        $language = $result[$i]['language'];
        $category = $result[$i]['category'];
        $thumbnail = $result[$i]['thumbnail'];
        $isDisabled = $result[$i]['disabled'];
        $stock = $result[$i]['stock'];
        $discount = $result[$i]['discount'];
  
        $serialNo = $i + 1;
        $state = $isDisabled === '0' ? 'false' : 'true';
  
        $str.="
          <tr>
            <td>".$serialNo."</td>
            <td><img src='".$thumbnail."' /></td>
            <td>".$ISBN."</td>
            <td>".$title."</td>
            <td>".$category."</td>
            <td>".$author."</td>
            <td>".$language."</td>
            <td>".$publisher."</td>
            <td>".$publicationYear."</td>
            <td>".$stock."</td>
            <td>".$discount."</td>
            <td>₹".$price."</td>
            <td>".$state."</td>
            <td><a class='edit-link' href='./manage.php?type=books&mode=edit&id=$ISBN'><i class='fa fa-pencil' aria-hidden='true'></i> Edit</a></td>
          </tr>";
      };
  
      $str .= "</tbody></table>";
  
      return $str;
    }
  }

  if(isset($_GET['mode']))
    if($_GET['mode'] === 'edit')
      $edit = editBook($db);
    else if($_GET['mode'] = 'create')
      $create = createBook();
    else $list = listBooks($db);
  else $list = listBooks($db);
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

  .form-box > input[type], .form-box select, .form-box textarea {
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
</style>
<div>
  <!-- <section></section> -->
  <section>
    <?php
      if(isset($_GET['mode']))
        if($_GET['mode'] === 'edit')
          echo $edit;
        else if($_GET['mode'] = 'create')
          echo $create;
        else echo $list;
      else echo $list;
    ?>
  </section>   
</div>