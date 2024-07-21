<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure le fichier de configuration
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier les données envoyées par le formulaire
    if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['country']) && isset($_POST['phone_number'])) {
        // Recevoir les données
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $country = $_POST['country'];
        $phone_number = $_POST['phone_number'];
        $first_key = bin2hex(random_bytes(16));
        
        // Préparer l'insertion des données dans la base de données
        $sql = "INSERT INTO users (first_name, last_name, email, password, country, phone_number, first_key) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier les variables à la déclaration préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "sssssss", $first_name, $last_name, $email, $password, $country, $phone_number, $first_key);
            
            // Tenter d'exécuter la déclaration préparée
            if (mysqli_stmt_execute($stmt)) {
                echo "Compte créé avec succès.";
            } else {
                echo "Erreur: Impossible d'exécuter la requête. " . mysqli_error($link);
            }
        } else {
            echo "Erreur: Impossible de préparer la requête. " . mysqli_error($link);
        }

        // Fermer la déclaration
        mysqli_stmt_close($stmt);
    } else {
        echo "Tous les champs sont requis.";
    }
}

// Fermer la connexion
mysqli_close($link);
?>

