<?php
  require_once("./configs/app-config.php");
  require_once("./classes/Database.php");

  $db = new Database($appConfig);
  $list = "";
  $create = "";
  $edit = "";

  function convertImageToBase64($file) {
    $path = $file['tmp_name'];
    $type = $file['type'];
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

    return $base64;
  }
   
  function checkOption($value, $option) {
    return $value === $option ? "selected" : "";
  }

  function addBookView($db) {
    $categories = $db->adminGetCategories();
    $categoryStr = "";

    for($i=0; $i < sizeof($categories); ++$i) {
      $categoryStr.="<option value='".$categories[$i]['name']."'>".$categories[$i]['name']."</option>";
    }

    return '
    <h2>Add Book</h2>
    <form name="add_book" class="form" action="./manage.php?type=books" method="post" enctype="multipart/form-data">
      <div class="form-box">
        <input name="ISBN" type="text" required placeholder="ISBN" title="ISBN"/>
        <input name="title" type="text" required placeholder="Title" title="Title" />
        <input name="price" type="number" required placeholder="Price" title="Price" />
        <input name="author" type="text" required placeholder="Author" title="Author" />
        <input name="publisher" type="text" required placeholder="Publisher" title="Publisher" />
        <input name="publication-year" type="number" required placeholder="Publication Year" title="Publication Year"/>
        <input name="language" type="text" readonly value="English" required placeholder="Language" title="Language"/>
        <select name="category" title="Category">'.$categoryStr.'</select>
        <img height="300" id="img-preview" width="200" alt="Uploaded image" />
        <input id="file-input" name="new-thumbnail" type="file" placeholder="Thumbnail Image" title="Thumbnail Image" accept="image/bmp, image/jpeg, image/png, image/gif" required />
        <select name="disabled" title="Is disabled?">
          <option value="0">Enabled</option>
          <option value="1">Disabled</option>
        </select>
        <input name="stock" type="number" required placeholder="Current Stock" title="Current stock quantity" required/>
        <input name="discount" type="number" placeholder="Discount" title="Discount"/>
        <div>
        <button class="add-button" type="submit">Add</button>
        <button class="add-button" type="reset">Reset</button>
        </div>
      </div>
    </form>';
  }

  function editBookView($db) {
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
    <form name="edit_book" class="form" action="./manage.php?type=books" method="post" enctype="multipart/form-data">
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
        <img id="img-preview" height="300" width="200" src="'.$thumbnail.'" alt="'.$title.'" />
        <input id="file-input" name="new-thumbnail" type="file" placeholder="Thumbnail Image" title="Thumbnail Image" accept="image/bmp, image/jpeg, image/png, image/gif"/>
        <input name="thumbnail" type="hidden" value="'.$thumbnail.'" />
        <select name="disabled" title="Is disabled?">
          <option value="0" '.checkOption($isDisabled, "0").'>Enabled</option>
          <option value="1" '.checkOption($isDisabled, "1").'>Disabled</option>
        </select>
        <input name="stock" type="number" required placeholder="Current Stock" value="'.$stock.'" title="Current stock quantity"/>
        <input name="discount" type="number" placeholder="Discount" value="'.$discount.'" title="Discount"/>
        <div>
          <button class="update" type="submit">Update</button>
          <button class="update" type="reset">Reset</button>
        </div>
      </div>
    </form>';
  }

  function updateBookDetails($db) {
    $id = $_POST['id'];
    $ISBN = $_POST['ISBN'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $author = $_POST['author']; 
    $publisher = $_POST['publisher'];
    $publication_year = $_POST['publication-year'];
    $language = $_POST['language'];
    $category = $_POST['category'];
    $thumbnail = isset($_FILES['new-thumbnail']) ? convertImageToBase64($_FILES['new-thumbnail']) : $_POST['thumbnail'];
    $disabled = $_POST['disabled'];
    $stock = $_POST['stock'];
    $discount = $_POST['discount'];

    $db->adminUpdateBookDetails($id, $ISBN, $title, $price, $author, $publisher, $publication_year, $language, $category, $thumbnail, $disabled, $stock, $discount);
  }

  function addBook($db) {
    $ISBN = $_POST['ISBN'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $author = $_POST['author']; 
    $publisher = $_POST['publisher'];
    $publication_year = $_POST['publication-year'];
    $language = $_POST['language'];
    $category = $_POST['category'];
    $thumbnail = convertImageToBase64($_FILES['new-thumbnail']);
    $disabled = $_POST['disabled'];
    $stock = $_POST['stock'];
    $discount = $_POST['discount'];

    $db->addBook($ISBN, $title, $price, $author, $publisher, $publication_year, $language, $category, $thumbnail, $disabled, $stock, $discount);
  }

  function listBooks($db) {
    if(isset($_POST['id']))
      updateBookDetails($db);
    else if(isset($_POST['ISBN']))
      addBook($db);
    else;

    $result = $db->adminGetAllBooks();
    $count = sizeOf($result);

    if($count === 0) echo "<p class='margin'><a class='button' href='./manage.php?type=books&mode=create'>Add Book</a></p><p>No Books Found!</p>";
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
            <td><img src='".$thumbnail."' height='150' width='100'/></td>
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
      $edit = editBookView($db);
    else if($_GET['mode'] = 'create')
      $create = addBookView($db);
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
    margin: 0 .7rem 3rem .7rem;
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

  .form-box button[type=submit], .form-box button[type=reset]  {
    padding: .5rem;
    display: inline-block;  
    font-size: 1.2rem;
    border-radius: 5px;
    cursor: pointer;
    align-self: baseline;
    margin: 0 10px
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

  #img-preview {
    border: solid thin var(--background-gray)
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
<script>
  function init() {
    const imgPreview = document.getElementById('img-preview');
    const imageSelectBtn = document.getElementById('file-input');

    function createPreview() {
      imageSelectBtn?.addEventListener('change', function(e) {
        imgPreview.setAttribute('src', null);

        const { target } = e;
        const [imgFile] = target['files'];
        const reader = new FileReader();

        reader.onload = function() {
          imgPreview.setAttribute('src', reader.result);
        }

        reader.readAsDataURL(imgFile)
      });
    }

    document.forms['add_book']?.addEventListener('reset', () => {
      imgPreview.setAttribute('src', null);
    })

    document.forms['edit_book']?.addEventListener('reset', (e) => {
      imgPreview.setAttribute('src', e.target['thumbnail'].value);
    })

    createPreview();
  }

  init();
</script>