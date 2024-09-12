<?php
require_once 'config.php';

//  connexion à la base de données
if ($link) {
    echo "Connexion réussie à la base de données!";
} else {
    echo "Erreur de connexion à la base de données.";
}
?>