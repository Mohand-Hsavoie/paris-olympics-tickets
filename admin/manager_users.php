<?php
session_start();
include '../src/php/config.php';

// Vérification si l'administrateur est connecté
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit();
}

// Requête pour récupérer tous les utilisateurs
$query = "SELECT id, email, first_name, last_name, country, phone_number, created_at FROM users";
$result = mysqli_query($link, $query);

if (!$result) {
    die('Erreur dans la requête : ' . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les utilisateurs</title>
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
    <div class="container mt-5">
        <h2 class="text-center">Liste des utilisateurs</h2>
        <table class="table table-bordered table-striped mt-4">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Pays</th>
                    <th>Téléphone</th>
                    <th>Date de création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($user['country']); ?></td>
                    <td><?php echo htmlspecialchars($user['phone_number']); ?></td>
                    <td><?php echo $user['created_at']; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                        <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Scripts Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Libérer le résultat de la mémoire
mysqli_free_result($result);
?>
