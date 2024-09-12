<?php
// Démarrer la session
session_start();

// Vérification si l'utilisateur est connecté en tant qu'administrateur
if (!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] !== true) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: /paris-olympics-tickets/admin/admin_login.php');
    exit();
}
?>
