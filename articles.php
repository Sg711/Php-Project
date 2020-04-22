<?php

require 'parts/functions.php';

session_start();

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Si tu lis ça, t'as perdu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container-fluid p-0">
        <?php
        include 'parts/menu_nav.php';
        ?>
    <div class="row">
        <h1 class="text-center col-6 offset-3">Liste des articles</h1>
    </div>

    <div class="row">
        <table class="table table-hover col-6 offset-3 mt-4">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Date de création</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><a href="article.php?id=7">jsJQOqsopujopujudpous</a></td>
                    <td class="col-2">Geralt</td>
                    <td class="col-3">Vendredi 13 septembre 2020 à 11:33:55</td>
                </tr>
            </tbody>
        </table>
    </div>
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>