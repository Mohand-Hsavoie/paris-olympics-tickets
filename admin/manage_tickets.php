<?php
session_start();
include '../src/php/config.php';

// Vérification si l'administrateur est connecté
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit();
}

// Récupérer tous les billets de la base de données
$query = "SELECT tickets.id, users.first_name, users.last_name, ticket_types.name AS ticket_type, tickets.security_code
          FROM tickets 
          JOIN users ON tickets.user_id = users.id 
          JOIN ticket_types ON tickets.ticket_type_id = ticket_types.id";
$result = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les billets</title>
    <!-- Inclure Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Gérer les billets</h1>

        <!-- Affichage d'un tableau Bootstrap pour la gestion des billets -->
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom utilisateur</th>
                    <th>Type de billet</th>
                    <th>Code de sécurité</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($ticket = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $ticket['id']; ?></td>
                        <td><?php echo $ticket['first_name'] . ' ' . $ticket['last_name']; ?></td>
                        <td><?php echo $ticket['ticket_type']; ?></td>
                        <td><?php echo $ticket['security_code']; ?></td>
                        <td>
                            <!-- Actions : Voir, Valider, Modifier, Supprimer -->
                            <a href="validate_ticket.php?id=<?php echo $ticket['id']; ?>" class="btn btn-success btn-sm">Valider</a>
                            <a href="edit_ticket.php?id=<?php echo $ticket['id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="delete_ticket.php?id=<?php echo $ticket['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce billet ?');" class="btn btn-danger btn-sm">Supprimer</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Formulaire pour ajouter un billet -->
        <h2 class="mt-5">Ajouter un billet</h2>
        <form action="add_ticket.php" method="post" class="border p-4 bg-light rounded">
            <div class="form-group">
                <label for="user">Utilisateur :</label>
                <input type="text" id="user" name="user" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="ticket_type">Type de billet :</label>
                <select id="ticket_type" name="ticket_type" class="form-control">
                    <option value="solo">Solo</option>
                    <option value="duo">Duo</option>
                    <option value="famille">Famille</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Ajouter un billet</button>
        </form>
    </div>

    <!-- Inclure Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
