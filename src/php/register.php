<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['register-firstname'];
    $last_name = $_POST['register-lastname'];
    $email = $_POST['register-email'];
    $password = password_hash($_POST['register-password'], PASSWORD_BCRYPT);
    $country = $_POST['register-country'];
    $phone_number = $_POST['register-phone'];
    $first_key = bin2hex(random_bytes(16)); // Générer une clé unique de 32 caractères

    // Préparer l'instruction SQL
    $sql = "INSERT INTO users (first_name, last_name, email, password, country, phone_number, first_key)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Préparer et exécuter la requête
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssss", $first_name, $last_name, $email, $password, $country, $phone_number, $first_key);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Inscription réussie!";
        } else {
            echo "Erreur: " . mysqli_stmt_error($stmt);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur de préparation: " . mysqli_error($link);
    }

    mysqli_close($link);
}
?>
