<?php
require_once 'config.php';

// Tester la connexion à la base de données
if ($link) {
    echo "Connexion réussie à la base de données!";
} else {
    echo "Erreur de connexion à la base de données.";
}
?>