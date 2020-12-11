<?php
    session_start(); 
    include('bd/connectionDB.php'); 
    // S'il n'y a pas de session alors on ne va pas sur cette page
    if(!isset($_SESSION['id'])) { 
        header('Location: index.php'); 
        
        exit; 
    }
    // Récupèration des informations de l'utilisateur connecté
    $afficher_profil = $DB->query("SELECT * FROM user WHERE id = ?", 
    array($_SESSION['id']));
    
    $afficher_profil = $afficher_profil->fetch(); 
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="./styles/style.css">
        <title>Medisafe - Mon profil</title>
    </head>
    <body>
        <?php
            require_once('navbar.php');
        ?>
        <div class="container">
            <h2>Bonjour <?= $afficher_profil['firstname'] . " " . $afficher_profil['lastname']; ?> !</h2>
            <div>Quelques informations sur vous : </div>
            <ul>
                <li>Votre id est : <?= $afficher_profil['id'] ?></li>
                <li>Votre mail est : <?= $afficher_profil['mail'] ?></li>
                <li>Votre compte a été crée le : <?= $afficher_profil['created_date'] ?></li>
            </ul>
            <div class="col-12 offset-1 col-lg-8 offset-lg-2 div-wrapper d-flex justify-content-center align-items-center">
                <div class="d-flex justify-content-center margin-top">
                    <a class="btn btn-primary" href="index.php">Accueil</a>
                    <a class="btn btn-warning" href="edit-profile.php">Modifier</a>
                </div>
            </div>
        </div>
    </body>
</html>