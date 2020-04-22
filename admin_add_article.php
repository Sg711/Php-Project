<?php
require 'parts/functions.php';
session_start();

//Appel des variables
if(
    isset($_POST['title']) &&
    isset($_POST['content'])
){
    //Vérif
    if(!preg_match('/^.{4,150}$/', $_POST['title'])){
        $errors[] = 'Le titre doit contenir entre 4 et 150 caractères !';
    }
    if(mb_strlen($_POST['content']) <= 4 ||  mb_strlen($_POST['content']) >=20000){
        $errors[] = 'L\'article doit contenir entre 4 et 20000 caractères !';
    }

    //Si pas d'erreurs
    if(!isset($errors)){
        //Connexion bdd
        try{
            $bdd = new PDO('mysql:host=localhost;dbname=projectphp;charset=utf8', 'root', '');
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(Exception $e){
            die('Il y a un problème avec la bdd : ' . $e->getMessage());
        }

        //Ajout article
        $response = $bdd->prepare('INSERT INTO articles(title,author,create_date,content) VALUES(?,?,?,?)');

        $response->execute([
            $_POST['title'],
            $_SESSION['user']['id'],
            date('Y-m-d H:i:s'),
            $_POST['content']
        ]);

        //Vérif
        if($response->rowCount() > 0){
            $successMessage = 'Votre article a été créé !';
        } else {
            $errors[] = 'Problème avec la bdd';
        }

        //Close
        $response->closeCursor();
    }
}
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
    <div class="container-fluid p-0"></div>

    <?php
    include 'parts/menu_nav.php';
    ?>

    <div class="row m-4">
        <div class="col-12 text-center">
            <h1>  Administration :  Ajouter un Article</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-4 offset-4">
            <?php
            //Affichage des erreurs

            if(isset($errors)){
                foreach($errors as $error){
                    echo '<p class="text-white bg-danger text-center p-2">'.$error. '</p>';
                }
            }

            //Masquer le formulaire si success
            if(isset($successMessage)){
                echo '<p class="bg-success text-white text-center p-3">'.$successMessage.'</p></div';
            } else {
            ?>
                <form action=""  method="POST">

                    <div class="form-group">
                        <label for="title">Titre</label>
                        <input type="text" name="title" id="title" class="form-control" >
                    </div>

                    <div class="form-group">
                        <label for="content">Article</label>
                        <textarea class="form-control" name="content" id="content" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-success col-12 " type="submit" value="Créer">
                    </div>

                </form>
            <?php }?>
        </div>
    </div>

<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>