<?php require_once("./partials/admin-session.php"); ?>
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
        padding: 1rem;
        background-color: var(--background-cream);
        border: solid thin var(--background-gray);
      }

      .content {
        flex-grow: 1;
      }

      .table .table thead tr {
        background-color: var(--background-cream) !important;
      }

      .choose-publisher {
        padding: .5rem .5rem;
        font-size: 1.2rem;
        line-height: 1.8rem;
        width: 100%;
        border: solid thin #333;
      }

      .filter-controls > h3 {
        font-size: 1.2rem;
        margin: 1.5rem 0 .6rem 0;
      }

      .total-sales {
        font-weight: 300;
        font-size: 1.3rem;
        line-height: 2rem;
      }

      .total-sales strong {
        font-weight: 400;
      }

      .table td{
        font-weight: 300;
        text-align: center;
      }

      .filter-button {
        padding: .5rem;
        display: inline-block;
        font-size: 1rem;
        border-radius: 5px;
        cursor: pointer;
        align-self: baseline;
        margin: 1rem 1rem .5rem 0;
        border: solid thin #333;
      }

      .filter-date {
        font-size: 1.1rem;
        padding: .5rem;
        display: block;
        width: 100%;
        margin-bottom: 1rem;
        box-sizing: border-box;
      }

      .date_details {
        font-size: 1.2rem;
        margin-top: -1rem;
        margin-bottom: 1rem;
      }
    </style>
    <script src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
  </head>
  <body>
    <?php
      require_once("./partials/full-header.php");
    ?>
    <main id="main" class="main bmb-container"></main>
    <script type="text/babel" src="./jsx/sales.js"></script>
    <script type="text/babel" data-type="module">
      const main = document.getElementById('main')
      const root = ReactDOM.createRoot(main);
      root.render(<SalesApp />);
    </script>
    <?php require_once("./partials/footer.php"); ?>
  </body>
</html> 