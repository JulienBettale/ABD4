 <?php
    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté au site.
    session_destroy(); // Permet de détruire une session.

    header('Location: index.php');
    exit;
 ?>