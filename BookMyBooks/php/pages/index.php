<!DOCTYPE html>
<html lnag="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BookMyBooks</title>
  </head>
  <body>
    <?php
      class Session {
        function __construct() {
          echo "This is the constructor invoked";
        }
      }

      new Session();
    ?>
  </body>
</html>