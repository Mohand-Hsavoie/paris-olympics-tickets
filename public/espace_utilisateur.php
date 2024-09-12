<?php
require_once ('../src/php/config.php');
session_start();
// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION['user_id'])) {
    // Rediriger vers la page d'authentification si l'utilisateur n'est pas connecté
    header('Location:authentification.html');
    exit();
}
// Récupérer les informations de session
$user_id = $_SESSION['user_id'];
$first_name = $_SESSION['first_name'];
$email = $_SESSION['email'];

// Récupérer les billets de l'utilisateur depuis la base de données
$query = "SELECT id FROM tickets WHERE user_id = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$tickets = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Utilisateur</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div id="menu-container"></div>

<script>
    fetch('menu.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('menu-container').innerHTML = data;
        });
</script>

    <div class="container mt-5">
        <h1>Espace Utilisateur</h1>
        <h2>Bonjour, <span id="user_name"><?php echo htmlspecialchars($first_name); ?></span></h2>

        <h3>Vos achats</h3>
        <div id="achats-container">
            <!-- Les achats seront chargés ici -->
        </div>
    </div>
    
    <h3>Vos billets</h3>
<table class="table">
    <thead>
        <tr>
            <th>Numéro de billet</th>
            <th>Télécharger</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tickets as $ticket): ?>
        <tr>
            <td><?php echo htmlspecialchars($ticket['id']); ?></td>
            <td><a href="/paris-olympics-tickets/src/tickets/ticket_<?php echo $ticket['id']; ?>.pdf" download>Télécharger</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    <!-- Scripts JS de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!--fichier JS -->
    <script src="js/espace_utilisateur.js"></script>
</body>
</html>
