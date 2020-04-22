<?php
require 'parts/functions.php';
session_start();

//Si user non connecté
if(!isConnected()){

    //Appel des variables
    if(
        isset($_POST['email']) &&
        isset($_POST['password'])
    ){
        //Vérif
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $errors[] = 'Email invalide !';
        }

        if(!preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[ !"#$%&\'()*+,\-\.\/:;<=>?\\\\@[\]\^_`{|}~]).{8,1000}$/', $_POST['password'])){
            $errors[] = 'Mot de passe incorrect !';
        }

        //Si pas d'erreurs
        if(!isset($errors)){

            //Connexion
            try{
                $bdd = new PDO('mysql:host=localhost;dbname=projectphp;charset=utf8', 'root', '');
                $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(Exception $e){
                die('Il y a un problème avec la bdd : ' . $e->getMessage());
            }

            $response = $bdd->prepare("SELECT * FROM users WHERE email = ? ");

            $response->execute([
                $_POST['email'],
            ]);

            $user = $response->fetch();

            if(empty($user)){
                $errors[]='Adresse mail ou mot de passe incorrect !';

            }else if(password_verify($_POST['password'],$user['password'])){

                $successMessage='Connexion réussi ! ';

                $_SESSION['user'] = $user;

            }else{
                $errors[]='Adresse mail ou mot de passe incorrect  !';
            }
        }
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
    <div class="container-fluid p-0">
    <?php
    include 'parts/menu_nav.php';
    ?>
    <div class="row m-3">
        <div class="col-4 offset-4">
            <?php
            //Affichage des erreurs
            if(isset($errors)){
                echo '<div class="row m-5">
                <div class="col-12  p-2 bg-danger"><ul class="m-0">';
                foreach($errors as $error){
                    echo '<li class="text-white">'.$error. '</li>';
                }
                echo '</ul></div></div>';
            }

            //Masquer le formulaire
            if(isset($successMessage)){
                echo ' <div class="row m-5">
                <div class="col-12 cadre-info p-2 bg-success">   <p class="text-white text-center m-0">'.$successMessage.'</p></div></div>';
            } else {

                if(!isConnected()){
            ?>

                <form action="" method="POST">
                    <legend class="text-center">Connexion</legend>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" name="email" id="email" placeholder="alice@exemple.fr">
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input class="form-control" type="password" name="password" id="password" >
                    </div>

                    <div class="form-group">
                        <input class="btn btn-success col-12 my-2" type="submit" value="Connexion">
                    </div>
                </form>
            <?php
                }else{
                    echo'<p style="color:red;">Vous êtes déjà connecté !</p>';
                }
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