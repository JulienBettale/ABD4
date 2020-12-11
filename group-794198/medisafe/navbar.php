<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php"><img src="./images/logo.png" alt="Medisafe" width="160"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php
                if(!isset($_SESSION['id'])){ // Si on ne détecte pas de session alors on verra les liens ci-dessous
            ?>
            <?php
                } else { // Sinon s'il y a une session alors on verra les liens ci-dessous
            ?>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Mon profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="import.php">Importer</a>
                </li>
            <?php
                } 
            ?>
        </ul>
        <ul class="navbar-nav ml-auto">
            <?php
                if(!isset($_SESSION['id'])){ // Si on ne détecte pas de session alors on verra les liens ci-dessous
            ?>
                    <li class="nav-item">
                        <a class="nav-link" href="registration.php">Inscription</a> <!-- Liens de nos futures pages -->
                    </li>
                    <li>
                        <a class="nav-link" href="connection.php">Connexion</a>
                    </li>
            <?php
                } else { // Sinon s'il y a une session alors on verra les liens ci-dessous
            ?>
                <li class="nav-item">
                    <a class="nav-link" href="disconnection.php">Déconnexion</a>
                </li>
            <?php
                } 
            ?>
        </ul>
    </div>
</nav>