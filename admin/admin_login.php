<?php
session_start();

// Si l'utilisateur est déjà connecté, rediriger vers le tableau de bord
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin_dashboard.php');
    exit();
}
// Générer un token CSRF pour éviter les attaques CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="col-md-6 offset-md-3">
        <h2 class="text-center">Se connecter espace admin</h2>
        <form method="post" action="admin_login_process.php">
            <!-- Champ pour l'adresse e-mail -->
            <div class="form-group">
                <input type="email" class="form-control" id="login-email" name="email" placeholder="Adresse e-mail*" required>
            </div>
            <!-- Champ pour le mot de passe -->
            <div class="form-group">
                <input type="password" class="form-control" id="login-password" name="password" placeholder="Mot de passe*" required>
            </div>
            <!-- Jeton CSRF caché -->
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            <!-- Bouton de soumission -->
            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </form>
    </div>
</div>
</body>
</html>
