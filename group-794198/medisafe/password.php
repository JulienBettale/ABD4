<?php
    session_start();
    include('bd/connectionDB.php');
 
    if (isset($_SESSION['id'])){
        header('Location: index.php');
        exit;
    }

    if(!empty($_POST)) {
        extract($_POST);
        $valid = true;

        if (isset($_POST['oublie'])) {
            $mail = htmlentities(strtolower(trim($mail))); // On récupère le mail afin d envoyer le mail pour la récupèration du mot de passe 

            // Si le mail est vide alors on ne traite pas
            if(empty($mail)) {
                $valid = false;
                $er_mail = "Il faut mettre un mail";
            }

            if($valid) {
                $verify_mail = $DB->query("SELECT lastname, firstname, mail, n_pwd
                FROM user WHERE mail = ?",
                array($mail));

                $verify_mail = $verify_mail->fetch();

                if(isset($verify_mail['mail'])) {
                    if($verify_mail['n_pwd'] == 0) {
                        // Génèrer un mot de passe à l'aide de la fonction RAND
                        $new_pass = rand();
                        // Le mieux serait de générer un nombre aléatoire entre 7 et 10 caractères (Lettres et chiffres)
                        $new_pass_crypt = crypt($new_pass, '$6$rounds=5000$rattrapagearchitecturebasededonnee$');
 
                        $objet = 'Nouveau mot de passe';
                        $to = $verify_mail['mail'];
                        
                        // Création du header du mail.
                        $header = "From: medisafe <no-reply@test.com> \n";
                        $header .= "Reply-To: ".$to."\n"; 
                        $header .= "MIME-version: 1.0\n";
                        $header .= "Content-type: text/html; charset=utf-8\n";
                        $header .= "Content-Transfer-Encoding: 8bit";

                        // Contenu de votre message
                        $contenu =  "<html>".
                            "<body>".
                            "<p style='text-align: center; font-size: 18px'><b>Bonjour Mr, Mme".$verify_mail['firstname']."</b>,</p><br/>".
                            "<p style='text-align: justify'><i><b>Nouveau mot de passe : </b></i>".$new_pass."</p><br/>".
                            "</body>".
                            "</html>";
                        // Envoi du mail
                        mail($to, $objet, $contenu, $header);
                        
                        $DB->insert("UPDATE user SET pwd = ?, n_pwd = 1 WHERE mail = ?", 
                            array($new_pass_crypt, $verify_mail['mail']));

                        echo $new_pass;
                    }
                }
                header('Location: connection.php');
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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="./styles/style.css">
        <title>Medisafe - Mot de passe oublié</title>
    </head>
    <body>
        <?php
            require_once('navbar.php');
        ?>
        <div class="container">
            <div class="row">
                <dix class="col-sm-0 col-md-2 col-lg-3"></dix>
                <dix class="col-sm-12 col-md-8 col-lg-6">
                    <h1>Mot de passe oublié</h1>
                    <br>
                    <div class="row">
                        <div class="col-12 form-box">
                            <form method="post">
                                <form method="post">
                                    <?php
                                        if (isset($er_mail)){
                                    ?>
                                    <div><?= $er_mail ?></div>
                                    <?php
                                        }
                                    ?>
                                    <div class="form-group">
                                        <label for="mail4">Email</label>
                                        <input type="email" class="form-control" id="mail4" placeholder="Adresse mail" name="mail" value="<?php if(isset($mail)){ echo $mail; }?>" required>
                                    </div>
                                    <div class="col-12 offset-1 col-lg-8 offset-lg-2 div-wrapper d-flex justify-content-center align-items-center">
                                        <div class="d-flex justify-content-center margin-top">  
                                            <button class="btn btn-primary" type="submit" name="oublie">Envoyer</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>