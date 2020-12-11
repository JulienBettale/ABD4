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

        // On se place sur le bon formulaire grâce au "name" de la balise "input"
        if (isset($_POST['inscription'])){

            $lastname  = htmlentities(trim($lastname)); // On récupère le nom
            $firstname = htmlentities(trim($firstname)); // on récupère le prénom
            $mail = htmlentities(strtolower(trim($mail))); // On récupère le mail
            $pwd = trim($pwd); // On récupère le mot de passe 
            $confpwd = trim($confpwd); // On récupère la confirmation du mot de passe

            // Vérification du nom
            if(empty($lastname)){
                $valid = false;
                $er_lastname = ("Le nom de l'utilisateur ne peut pas être vide");
            }       

            // Vérification du prénom
            if(empty($firstname)){
                $valid = false;
                $er_firstname = ("Le prenom de l'utilisateur ne peut pas être vide");
            }       

            // Vérification du mail
            if(empty($mail)){
                $valid = false;
                $er_mail = "Le mail ne peut pas être vide";

                // On vérifit que le mail est dans le bon format
            }elseif(!preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $mail)){
                $valid = false;
                $er_mail = "Le mail n'est pas valide";

            }else{
                // On vérifit que le mail est disponible
                $req_mail = $DB->query("SELECT mail FROM user WHERE mail = ?",
                    array($mail));

                $req_mail = $req_mail->fetch();

                if ($req_mail['mail'] <> ""){
                    $valid = false;
                    $er_mail = "Ce mail existe déjà";
                }
            }

            // Vérification du mot de passe
            if(empty($pwd)) {
                $valid = false;
                $er_pwd = "Le mot de passe ne peut pas être vide";

            }elseif($pwd != $confpwd){
                $valid = false;
                $er_pwd = "La confirmation du mot de passe ne correspond pas";
            }

            // Si toutes les conditions sont remplies alors on fait le traitement
            if($valid){

                $pwd = crypt($pwd, '$6$rounds=5000$rattrapagearchitecturebasededonnee$');

                $created_date = date('Y-m-d H:i:s');

                $token = bin2hex(random_bytes(12));

                // On insert nos données dans la table user
                $DB->insert("INSERT INTO  user (lastname, firstname, mail, pwd, created_date, token) VALUES (?,?,?,?,?,?)", 
                    array($lastname, $firstname, $mail, $pwd, $created_date, $token));

                $req = $DB->query("SELECT FROM user WHERE mail = ?", array($mail));

                $req = $req->fetch();

                $mail_to = $req['mail'];

                // Header de l'email
                $header = "From: no-reply@gmail.com\n";
                $header .= "MINE-version: 1.0\n";
                $header .= "Content-type: text/html; charset=utf-8\n";
                $header .= "Content-Transfer-ncoding: 8bit";

                // Contenu du mail en format HMTL
                $contenu = '<p>Bonjour ' . $req['firstname'] . ',</p><br>
                <p>Veuillez confirmer votre compte <a href="http://www.domaine.com/conf.php?id=' . $req['id'] . '&token=' . $token . '">Valider</a><p>';
                
                mail($mail_to, 'Confirmation de votre compte', $contenu, $header);

                header('Location: index.php');
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
        <title>Medisafe - Inscription</title>
    </head>
    <body>
        <?php
            require_once('navbar.php');
        ?>
        <div class="container">
            <div class="row">
                <dix class="col-sm-0 col-md-2 col-lg-3"></dix>
                <dix class="col-sm-12 col-md-8 col-lg-6"> 
                    <h1>Inscription</h1>
                    <br>
                    <div class="row">
                        <div class="col-12 form-box">
                            <form method="post">
                                <?php
                                    // S'il y a une erreur sur le nom alors on affiche
                                    if (isset($lastname)){
                                    ?>
                                        <div><?= $lastname ?></div>
                                    <?php   
                                    }
                                ?>
                                 <div class="form-group">
                                    <label for="lastname1">Nom</label>
                                    <input type="text" class="form-control" id="lastname1" placeholder="Votre nom" name="lastname" value="<?php if(isset($lastname)){ echo $lastname; }?>" required>   
                                </div>
                                <?php
                                    if (isset($firstname)){
                                    ?>
                                        <div><?= $firstname ?></div>
                                    <?php   
                                    }
                                ?>
                                <div class="form-group">
                                    <label for="firstname1">Prénom</label>
                                    <input type="text" class="form-control" id="firstname1" placeholder="Votre prénom" name="firstname" value="<?php if(isset($firstname)){ echo $firstname; }?>" required>   
                                </div>
                                <?php
                                    if (isset($er_mail)){
                                    ?>
                                        <div><?= $er_mail ?></div>
                                    <?php   
                                    }
                                ?>
                                <div class="form-group">
                                    <label for="mail2">Email</label>
                                    <input type="email" class="form-control" id="mail2" placeholder="Adresse mail" name="mail" value="<?php if(isset($mail)){ echo $mail; }?>" required>
                                </div>
        
                                <?php
                                    if (isset($er_pwd)){
                                    ?>
                                        <div><?= $er_pwd ?></div>
                                    <?php   
                                    }
                                ?>
                                <div class="form-group">
                                    <label for="pwd2">Mot de passe</label>
                                    <input type="password" class="form-control" id="pwd2" placeholder="Mot de passe" name="pwd" value="<?php if(isset($pwd)){ echo $pwd; }?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="conf_pwd1">Confirmé le mot de passe</label>
                                    <input type="password" class="form-control" id="conf_pwd1" placeholder="Confirmer le mot de passe" name="confpwd" required>
                                </div>
                                <div class="col-12 offset-1 col-lg-8 offset-lg-2 div-wrapper d-flex justify-content-center align-items-center">
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-primary" type="submit" name="inscription">Envoyer</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>