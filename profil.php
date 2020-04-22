<?php

require 'parts/functions.php';

session_start();

?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>J'apprecie les fruits au sirop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container-fluid p-0">
        <?php
        include 'parts/menu_nav.php';
        ?>
        <div class="row m-5">
            <div class="col-6 offset-3">
                <?php

                if(isConnected()){
                    if( $_SESSION['user']['admin'] == 0){
                        $status='Membre';
                    }else{
                        $status='Administrateur';
                    }

                ?>
                    <table class="table table-striped table-bordered">
                    <tr>
                        <td>
                            <strong>Email :</strong> <?php echo htmlspecialchars($_SESSION['user']['email']) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Prénom : </strong> <?php echo htmlspecialchars($_SESSION['user']['firstname']) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Nom :</strong> <?php echo htmlspecialchars($_SESSION['user']['lastname']) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Statut :</strong> <?php echo $status ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Date d'inscription :</strong> <?php echo htmlspecialchars($_SESSION['user']['register_date']) ?>
                        </td>
                    </tr>
                </table>
                <?php
                }else{
                    echo '<div class="row m-5"><div class="col-6 offset-3  p-2 bg-danger">   <p class="text-white text-center m-0">Vous devez être connecté pour accèder à cette page !</p></div></div>';
                }
                ?>
            </div>
        </div>

<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>