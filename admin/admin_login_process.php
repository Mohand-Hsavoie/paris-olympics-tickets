<?php
session_start();
include('../src/php/config.php');

// Vérification du token CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Token CSRF invalide.");
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier que les champs email et mot de passe sont remplis
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Préparation de requête pour vérifier si l'utilisateur existe
        $query = "SELECT * FROM admins WHERE email = ?";
        if ($stmt = $link->prepare($query)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            // voir si administrateur avec cet e-mail a été trouvé
            if ($result->num_rows === 1) {
                $admin = $result->fetch_assoc();

                // controe de hachage mot de passe
                if (password_verify($password, $admin['password'])) {
                    // Authentification réussie, créer une session
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_email'] = $admin['email'];
                    $_SESSION['username'] = $admin['username'];

                    // Rediriger vers le tableau de bord
                    header("Location: admin_dashboard.php");
                    exit();
                } else {
                    // Mot de passe incorrect
                    echo "Mot de passe incorrect.";
                }
            } else {
                // Aucun administrateur trouvé avec cet email
                echo "Administrateur non trouvé.";
            }

            $stmt->close();
        } else {
            echo "Erreur lors de la préparation de la requête : " . $link->error;
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
} else {
    echo "Méthode de requête non valide.";
}
?>
