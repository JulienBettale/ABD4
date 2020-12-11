<?php
    session_start();

    include('bd/connectionDB.php');

    if (!isset($_SESSION['id'])){
        header('Location: index.php');
        exit;
    }

    // On récupère les informations de l'utilisateur connecté
    $afficher_profil = $DB->query("SELECT * FROM user WHERE id = ?",
        array($_SESSION['id']));

    $afficher_profil = $afficher_profil->fetch();

    if(!empty($_POST)){
        extract($_POST);
        $valid = true;

        if (isset($_POST['edit'])){

            $lastname = htmlentities(trim($lastname));
            $firstname = htmlentities(trim($firstname));
            $mail = htmlentities(strtolower(trim($mail)));

            if(empty($lastname)){
                $valid = false;
                $er_lastname = "Il faut mettre un nom";
            }
            if(empty($firstname)){
                $valid = false;
                $er_firstname = "Il faut mettre un prénom";
            }
            if(empty($mail)){
                $valid = false;
                $er_mail = "Il faut mettre un mail";

            }elseif(!preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $mail)){
                $valid = false;
                $er_mail = "Le mail n'est pas valide";

            }else{
                $req_mail = $DB->query("SELECT mail 
                    FROM user WHERE mail = ?",
                    array($mail));

                $req_mail = $req_mail->fetch();

                if ($req_mail['mail'] <> "" && $_SESSION['mail'] != $req_mail['mail']){
                    $valid = false;
                    $er_mail = "Ce mail existe déjà";
                }
            }
            if ($valid){

                $DB->insert("UPDATE user SET firstname = ?, lastname = ?, mail = ? 
                    WHERE id = ?", 
                    array($firstname, $lastname,$mail, $_SESSION['id']));

                $_SESSION['lastname'] = $lastname;
                $_SESSION['firstname'] = $firstname;
                $_SESSION['mail'] = $mail;

                header('Location:  profile.php');

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
        <title>Medisafe - Modifier votre profil</title>
    </head>
    <body>
        <?php
            require_once('navbar.php');
        ?>
        <div class="container">
            <div class="row">
                <dix class="col-sm-0 col-md-2 col-lg-3"></dix>
                <dix class="col-sm-12 col-md-8 col-lg-6"> 
                    <h1>Mise à jour de votre profil</h1>
                    <br>
                    <div class="row">
                        <div class="col-12 form-box">
                            <form method="post">
                                <?php
                                    if (isset($er_nom)){
                                    ?>
                                        <div><?= $er_nom ?></div>
                                    <?php   
                                    }
                                ?>
                                    <div class="form-group">
                                        <label for="lastname2">Nom de famille</label>
                                        <input type="text" class="form-control margin-bottom-20" id="lastname2" placeholder="Votre nom" name="lastname" value="<?php if(isset($lastname)){ echo $lastname; }else{ echo $afficher_profil['lastname'];}?>" required>   
                                    </div>
                                    <?php
                                    if (isset($er_prenom)){
                                    ?>
                                        <div><?= $er_prenom ?></div>
                                    <?php   
                                    }
                                ?>
                                <div class="form-group">
                                    <label for="firstname2">Prénom</label>
                                    <input type="text" class="form-control margin-bottom-20" id="firstname2" placeholder="Votre prénom" name="firstname" value="<?php if(isset($firstname)){ echo $firstname; }else{ echo $afficher_profil['firstname'];}?>" required>   
                                </div>
                                <?php
                                    if (isset($er_mail)){
                                    ?>
                                        <div><?= $er_mail ?></div>
                                    <?php   
                                    }
                                ?>
                                <div class="form-group">
                                    <label for="mail3">Adresse mail</label>
                                    <input type="email" class="form-control margin-bottom-20" id="mail3" placeholder="Adresse mail" name="mail" value="<?php if(isset($mail)){ echo $mail; }else{ echo $afficher_profil['mail'];}?>" required>
                                </div>
                                <div class="col-12 offset-1 col-lg-8 offset-lg-2 div-wrapper d-flex justify-content-center align-items-center">
                                    <div class="d-flex justify-content-center margin-top">
                                        <button class="btn btn-primary" type="submit" name="edit">Modifier</button>
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