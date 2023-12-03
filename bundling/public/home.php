<!DOCTYPE html>
<html lang = "en">
   <head>
      <meta charset = "UTF-8">
      <title>React App</title>
   </head>
   <body>
      <?php echo "this is working, yes I do like to make this work" ?>
      <div id = "app"></div>
      <?php
         $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
      ?>
      <script src="<?= $actual_link ?>assets/home.js"></script>
   </body>
</html>