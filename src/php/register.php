<?php
// Démarrer la session
session_start();
//fichier de configuration
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification les données envoyées par le formulaire
    if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['country']) && isset($_POST['phone_number'])) {
        // Recevoir les données
        $first_name = mysqli_real_escape_string($link, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($link, $_POST['last_name']);
        $email = mysqli_real_escape_string($link, $_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $country = mysqli_real_escape_string($link, $_POST['country']);
        $phone_number = mysqli_real_escape_string($link, $_POST['phone_number']);
        $first_key = bin2hex(random_bytes(16));

        // l'insertion des données dans la base de données
        $sql = "INSERT INTO users (first_name, last_name, email, password, country, phone_number, first_key) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier les variables à la déclaration préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "sssssss", $first_name, $last_name, $email, $password, $country, $phone_number, $first_key);

            // exécuter la déclaration préparée
            if (mysqli_stmt_execute($stmt)) {
                // Stocker les informations de l'utilisateur dans la session
                $_SESSION['user_id'] = mysqli_insert_id($link);
                $_SESSION['first_name'] = $first_name;
                $_SESSION['email'] = $email;
                // Rediriger l'utilisateur vers son espace personnel
                header('Location: ../../public/espace_utilisateur.php');
                exit;
            } else {
                echo "Erreur: Impossible d'exécuter la requête. " . mysqli_stmt_error($stmt);
            }
        } else {
            echo "Erreur: Impossible de préparer la requête. " . mysqli_error($link);
        }
        // Fermer la déclaration
        mysqli_stmt_close($stmt);
    } else {
        echo "Tous les champs sont requis.<br>";
    
    }
}
// Fermer la connexion
mysqli_close($link);
?>