<?php
require 'parts/functions.php';
session_start();

if(isConnected()){
    unset($_SESSION['user']);
    $success = true;
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>J'ai pas de truc drole a mettre</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container-fluid p-0">
    <?php
    include 'parts/menu_nav.php';

    if(isset($success)){
        echo '<div class="row m-5">
        <div class="col-6 offset-3  p-2 bg-success">   <p class="text-white text-center m-0">Vous avez bien été déconnecté !</p></div></div>';
    } else {
        echo '<div class="row m-5">
        <div class="col-6 offset-3  p-2 bg-danger">   <p class="text-white text-center m-0">Vous êtes déjà déconnecté !</p></div></div>';
    }
    ?>

<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>