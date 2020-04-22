<?php
require 'parts/functions.php';
session_start();
//Captcha google
require 'recaptchaValid.php';
//Appel des variables
if(
    isset($_POST['email']) &&
    isset($_POST['password']) &&
    isset($_POST['confirm-password']) &&
    isset($_POST['firstname']) &&
    isset($_POST['lastname']) &&
    isset($_POST['g-recaptcha-response'])
){
    //Vérif

    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors[] = 'Email invalide !';
    }

    if(!preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[ !"#$%&\'()*+,\-\.\/:;<=>?\\\\@[\]\^_`{|}~]).{8,1000}$/', $_POST['password'])){
        $errors[] = 'Votre mot de passe doit contenir minimum 1 maj, 1 min, 1 chiffre et un caractère spécial !';
    }

    if($_POST['confirm-password'] != $_POST['password']){
        $errors[] = 'Confirmation !';
    }

    if(!preg_match('/^.{2,50}$/', $_POST['firstname'])){
        $errors[] = 'Prénom doit contenir entre 2 et 50 caractères !';
    }

    if(!preg_match('/^.{2,50}$/', $_POST['lastname'])){
        $errors[] = 'Nom doit contenir entre 2 et 50 caractères !';
    }

    if(!recaptcha_valid($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'])){
        $errors[] = 'Captcha invalide !';
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

        //Verif email
        $response = $bdd->prepare("SELECT email FROM users WHERE email = ?");

        $response->execute([
            $_POST['email']
        ]);
        $emailVerif = $response->fetch();

        if($emailVerif){
            $errors[]='Cette adresse mail est déjà prise';
        }else{

            //Add user bdd
            $response = $bdd->prepare('INSERT INTO users(email, password, firstname, lastname, admin, register_date, activated, register_token) VALUES(?,?,?,?,?,?,?,?)');

            $response->execute([
                $_POST['email'],
                password_hash($_POST['password'], PASSWORD_BCRYPT),
                $_POST['firstname'],
                $_POST['lastname'],
                0,
                date('Y-m-d H:i:s'),
                0,
                0
            ]);

            //Vérif
            if($response->rowCount() > 0){
                $successMessage = 'Votre compte a été créé !';
            } else {
                $errors[] = 'Problème avec la bdd';
            }
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
  <title>Coronavirus</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body>
    <div class="container-fluid p-0">
        <?php
        //Nav
        include 'parts/menu_nav.php';
        ?>
        <div class="row">
            <div class="col-6 offset-3">
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
                ?>
            </div>
        </div>

        <div class="row m-3">
            <div class="col-4 offset-4">
                <form action="" method="POST">
                    <legend class="text-center">INSCRIPTION</legend>

                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Mot de passe</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Confirmation mot de passe</label>
                        <input type="password" name="confirm-password" id="confirm-password" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Prénom</label>
                        <input type="text" name="firstname" id="firstname" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Nom</label>
                        <input type="text" name="lastname" id="lastname" class="form-control">
                    </div>

                    <!--  Recaptcha Google -->
                    <div class="g-recaptcha "  data-sitekey="6LdTwusUAAAAAIRDJwRituVSk-30INRPvzFMpPDA"></div>

                    <div class="form-group">
                        <input class="btn btn-success col-12 my-2" type="submit" value="Valider">
                    </div>

                </form>
            </div>
        </div>
        <?php } ?>
    </div>



<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>