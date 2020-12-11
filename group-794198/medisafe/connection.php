<?php
    session_start();
    include('bd/connectionDB.php'); // Fichier PHP contenant la connexion à la BDD

    // S'il y a une session alors on ne retourne plus sur cette page
    if(isset($_SESSION['id'])){
        header('Location: index.php');
        exit;
    }

    // Si la variable "$_Post" contient des informations alors on les traitres
    if(!empty($_POST)){
        extract($_POST);
        $valid = true;   

        if (isset($_POST['connection'])){

            $mail = htmlentities(strtolower(trim($mail)));
            $pwd = trim($pwd);

            if(empty($mail)){ // Vérification qu'il y est bien un mail de renseigné
                $valid = false;
                $er_mail = "Il faut mettre un mail";
            }

            if(empty($pwd)){ // Vérification qu'il y est bien un mot de passe de renseigné
                $valid = false;
                $er_pwd = "Il faut mettre un mot de passe";
            }

            // On fait une requéte pour savoir si le couple mail / mot de passe existe bien car le mail est unique !
            $req = $DB->query("SELECT * FROM user WHERE mail = ? AND pwd = ?",
                array($mail, crypt($pwd, '$6$rounds=5000$rattrapagearchitecturebasededonnee$')));

            $req = $req->fetch();

            // Si on a pas de résultat alors c'est qu'il n'y a pas d'utilisateur correspondant au couple mail / mot de passe
            if ($req['id'] == ""){
                $valid = false;
                $er_mail = "Le mail ou le mot de passe est incorrecte";
            } elseif($req['n_pwd'] == 1) { // On remet à zéro la demande de nouveau mot de passe s'il y a bien un couple mail / mot de passe
                $DB->insert("UPDATE user SET n_pwd = 0 WHERE id = ?",
                    array($req['id']));
            }
            
            // S'il y a un résultat alors on va charger la SESSION de l'utilisateur en utilisateur les variables $_SESSION
            if ($valid){

                $_SESSION['id'] = $req['id']; // id de l'utilisateur unique pour les requ�tes futures
                $_SESSION['lastname'] = $req['lastname'];
                $_SESSION['firstname'] = $req['firstname'];
                $_SESSION['mail'] = $req['mail'];

                header('Location:  index.php');
                exit;
            }   
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel="stylesheet" href="./styles/style.css">
        <title>Medisafe - Connexion</title>
    </head>
    <body>
        <?php
            require_once('navbar.php');
        ?>
        <div class="container">
            <div class="row">
                <dix class="col-sm-0 col-md-2 col-lg-3"></dix>
                <dix class="col-sm-12 col-md-8 col-lg-6">
                    <h1>Se connecter</h1>
                    <br>
                    <div class="row">
                        <div class="col-12 form-box">
                            <form method="post">
                                <?php
                                    if (isset($er_mail)) {
                                ?>
                                    <div><?= $er_mail ?></div>
                                <?php   
                                    }
                                ?>
                                <div class="form-group">
                                    <label for="mail1">Email</label>
                                    <input class="form-control" type="email" id="mail1" placeholder="Adresse mail" name="mail" value="<?php if(isset($mail)){ echo $mail; }?>" required>
                                </div>
                                <?php
                                    if (isset($er_pwd)){
                                ?>
                                    <div><?= $er_pwd ?></div>
                                <?php   
                                    }
                                ?>
                                <div class="form-group">
                                    <label for="pwd1">Mot de passe</label>
                                    <input class="form-control" type="password" id="pwd1" placeholder="Mot de passe" name="pwd" value="<?php if(isset($pwd)){ echo $pwd; }?>" required>
                                </div>
                                <div>
                                    <div class="col-12 offset-1 col-lg-8 offset-lg-2 div-wrapper d-flex justify-content-center align-items-center">
                                        <div class="d-flex justify-content-center">
                                            <button class="btn btn-primary" type="submit" name="connection">Connexion</button>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div>
                                    <div class="col-12 offset-1 col-lg-8 offset-lg-2 div-wrapper d-flex justify-content-center align-items-center">
                                        <div class="d-flex justify-content-center">
                                            <a class="stretched-link password" href="password.php">Mot de passe oublié</a>
                                        </div>
                                    </div>
                                </div>
                            <form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </body>
</html>