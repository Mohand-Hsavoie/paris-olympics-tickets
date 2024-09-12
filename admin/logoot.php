<?php
session_start();
session_unset(); // Supprimer toutes les variables de session
session_destroy(); // Détruire la session
header('Location: admin_login.php');
exit();
?>