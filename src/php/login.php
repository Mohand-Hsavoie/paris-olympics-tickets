<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];
    // Valider les entrées
    if (empty($email) || empty($password)) {
        echo "Veuillez entrer un email et un mot de passe.";
        exit;
    }

    // Préparer la requête SQL pour sélectionner l'utilisateur
    $sql = "SELECT id, first_name, email, password FROM users WHERE email = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        // Vérifier si l'utilisateur existe
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $id, $first_name, $email, $hashed_password);
            mysqli_stmt_fetch($stmt);

            // Vérifier le mot de passe
            if (password_verify($password, $hashed_password)) {
                // Stocker les informations dans la session
                $_SESSION['user_id'] = $id;
                $_SESSION['first_name'] = $first_name;
                $_SESSION['email'] = $email;
                $_SESSION['authenticated'] = true;
                // Redirection vers l'espace utilisateur
                header("Location:/paris-olympics-tickets/public/espace_utilisateur.php");
                exit;
            } else {
                echo "Mot de passe incorrect.";
            }
        } else {
            echo "Aucun utilisateur trouvé avec cet email.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur de préparation de la requête : " . mysqli_error($link);
    }

    mysqli_close($link);
}
?>
