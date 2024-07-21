<?php
// Afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php'; // Charger la configuration de la base de données

if (!$link) {
    die('Erreur de connexion : ' . mysqli_connect_error());
}
echo "Connexion réussie à la base de données!<br>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérification des données reçues
    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';

    // Récupération des données du formulaire
    $firstName = $_POST['firstname'] ?? '';
    $lastName = $_POST['lastname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $country = $_POST['country'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if ($firstName && $lastName && $email && $password && $country && $phone) {
        // Hashage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Génération de la clé unique
        $firstKey = bin2hex(random_bytes(16));

        // Préparation de la requête d'insertion
        $sql = "INSERT INTO users (first_name, last_name, email, password, country, phone_number, first_key) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssssss", $firstName, $lastName, $email, $hashedPassword, $country, $phone, $firstKey);
            if (mysqli_stmt_execute($stmt)) {
                echo "Compte créé avec succès !";
            } else {
                echo "Erreur lors de la création du compte : " . mysqli_error($link);
            }
        } else {
            echo "Erreur de préparation de la requête : " . mysqli_error($link);
        }

        // Fermer la déclaration
        mysqli_stmt_close($stmt);
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}

// Fermer la connexion
mysqli_close($link);
?>
