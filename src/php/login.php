<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['login-email'];
    $password = $_POST['login-password'];

    // Préparer l'instruction SQL
    $sql = "SELECT id, password FROM users WHERE email = ?";
    
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $id, $hashed_password);
        
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_fetch($stmt);
            if (password_verify($password, $hashed_password)) {
                // Démarrer une session et rediriger l'utilisateur
                session_start();
                $_SESSION['user_id'] = $id;
                header("Location: dashboard.php");
                exit;
            } else {
                echo "Mot de passe incorrect.";
            }
        } else {
            echo "Aucun utilisateur trouvé avec cet email.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur de préparation: " . mysqli_error($link);
    }

    mysqli_close($link);
}
?>
