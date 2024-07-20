
<?php
session_start();

// Vérifier si l'utilisateur est connecté, sinon rediriger vers la page de connexion
if (!isset($_SESSION['id'])) {
    header("location: ../public/authentification.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
</head>
<body>
    <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION["firstname"]); ?>!</h1>
    <p>C'est votre page d'accueil sécurisée.</p>
    <a href="logout.php">Se déconnecter</a>
</body>
</html>
