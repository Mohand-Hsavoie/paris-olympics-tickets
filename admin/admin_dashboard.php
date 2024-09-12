<?php
session_start();

// Vérification si l'administrateur est connecté
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

// Récupération du nom d'utilisateur pour l'afficher
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Administrateur';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Tableau de bord</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="manager_users.php">Gérer les utilisateurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_tickets.php">Gestion des tickets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logoot.php">Déconnexion</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Contenu de la page -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Bienvenue, <?php echo htmlspecialchars($username); ?> !</h1>
                <p class="lead">Utilisez les options du menu pour gérer les utilisateurs et les tickets.</p>
            </div>
        </div>
    </div>

    <!-- Scripts JavaScript pour Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
