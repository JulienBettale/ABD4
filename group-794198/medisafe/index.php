<?php
    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté au site.
    include('bd/connectionDB.php'); // Fichier PHP contenant la connexion au la BDD

    $query = $DB->query("SELECT * FROM employees ORDER BY EmployeeNumber");

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">        <link rel="stylesheet" href="./styles/style.css">
        <title>Medisafe - Accueil</title>
    </head>
    <body>
        <?php
            require_once('navbar.php');
        ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-8 col-lg-6">
                    <h1><img src="./images/logo.png" alt="Medisafe" width="350"></h1>
                </div>
                <?= $employeesNumber['employeesNumber']; ?>
            </div>
        </div>
        <div class="content">
            <?php
                if(!isset($_SESSION['id'])){
            ?>
            <div class="container container-index">
                <div class="row">
                    <h4 class="margin-0-auto">BIENVENUE CHEZ LE SPÉCIALISTE DE LA TROUSSE DE SECOURS</h4>
                    <br>
                    <br>
                    <p>Qui n'a jamais été spectateur ou acteur d'une situation nécessitant de porter secours ?</p>
                    <p>Les accidents du travail concernent en moyenne 35 salariés sur 1000 et pourtant seulement 20% des Français sont formés aux gestes de premiers secours. Medisafe s'engage à vos côtés en vous informant des gestes de premiers secours dans notre blog santé et sécurité.</p>
                    <p>Depuis 2010, grâce à nos produits, nous assurons la sécurité quotidienne de millions de collaborateurs. Notre expertise dans la création de trousses de secours entreprises conformes aux diverses normes françaises et européennes nous permettent de travailler auprès de grandes sociétés telles que Airbus, L'armée de Terre ou Total.</p>
                    <p>Nos trousses et armoires à pharmacie suivent sans cesse les exigences de la médecine du travail afin d'être conformes à l’article R4224-14 du Code du travail. Le contenu de votre trousse de premiers secours est pensé spécifiquement pour votre métier, votre sport ou autres risques. Compartimentage, format, matériau, isolant, sérigraphie, votre kit de premier secours est assemblé en France par les mains expertes de nos préparatrices en pharmacie.</p>
                    <p>Spécialiste de la vente en ligne de matériel de 1er secours, matériel médical, équipement d'hygiène et sécurité, Medisafe développe toute une gamme de produits dédiés aux entreprises, industries, artisans, secouristes, pompiers, hôpitaux etc. De l'extincteur incendie au gel hydroalcoolique ; nous assurons la protection de vos locaux comme de votre santé.</p>
                </div>
            </div>
                <?php
                    } else {
                ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <td>Employees Number</td>
                                <td>Surname</td>
                                <td>Given Name</td>
                                <td>Gender</td>
                                <td>City</td>
                                <td>Job Title</td>
                                <td>Departement Name</td>
                                <td>Store Location</td>
                                <td>Division</td>
                                <td>Age</td>
                                <td>Lenght Service</td>
                                <td>Absent Hours</td>
                                <td>Business Unit</td>
                            </tr>
                            <?php
                                while($row = $query->fetch()) {
                                    echo '
                                        <tr>
                                            <td>'.$row['EmployeeNumber'].'</td>
                                            <td>'.$row['Surname'].'</td>
                                            <td>'.$row['GivenName'].'</td>
                                            <td>'.$row['Gender'].'</td>
                                            <td>'.$row['City'].'</td>
                                            <td>'.$row['JobTitle'].'</td>
                                            <td>'.$row['DepartmentName'].'</td>
                                            <td>'.$row['StoreLocation'].'</td>
                                            <td>'.$row['Division'].'</td>
                                            <td>'.$row['Age'].'</td>
                                            <td>'.$row['LengthService'].'</td>
                                            <td>'.$row['AbsentHours'].'</td>
                                            <td>'.$row['BusinessUnit'].'</td>
                                        </tr>
                                    ';
                                }?>
                        </table>
                    </div>
                </div>
            </div>
                <?php
                    }
                ?>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </body>
</html>    