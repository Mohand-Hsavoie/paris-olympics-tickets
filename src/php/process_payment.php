<?php
require_once('config.php'); // Connexion à la base de données
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: /paris-olympics-tickets/public/authentification.html');
    exit();
}

// Vérifier si le panier existe
if (!isset($_SESSION['cart'], $_SESSION['total_amount'])) {
    header('Location: /paris-olympics-tickets/public/billetterie.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'];
$totalAmount = $_SESSION['total_amount'];

// Récupérer les informations de paiement depuis le formulaire
$card_number = $_POST['card_number'];
$expiry_date = $_POST['expiry_date'];
$cvv = $_POST['cvv'];

// Simuler la validation du paiement (à remplacer par une vraie API si nécessaire)
$payment_success = true; // Simuler que le paiement réussit toujours pour le projet

if ($payment_success) {
    // Générer la clé de sécurité de paiement (second_key)
    $second_key = bin2hex(random_bytes(16)); // Clé aléatoire de 16 octets

    // Récupérer la clé générée lors de la création du compte (first_key)
    $query = "SELECT first_key FROM users WHERE id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($first_key);
    $stmt->fetch();
    $stmt->close();

    // Concaténer les clés pour former le security_code
    $security_code = $first_key . $second_key;

    // Créer un billet pour chaque type de ticket dans le panier
    foreach ($cart as $ticket_type => $details) {
        $quantity = $details['quantity'];
        $ticket_type_id = null; // Initialiser la variable

        // Obtenir l'ID du type de ticket
        $get_ticket_type_query = "SELECT id FROM ticket_types WHERE name = ?";
        $stmt = $link->prepare($get_ticket_type_query);
        $stmt->bind_param("s", $ticket_type);
        $stmt->execute();
        $stmt->bind_result($ticket_type_id);
        $stmt->fetch();
        $stmt->close();

        if ($ticket_type_id === null) {
            // Si l'ID du type de ticket n'est pas trouvé
            continue;
        }

        for ($i = 0; $i < $quantity; $i++) {
            // Insérer un nouveau billet dans la base de données
            $insert_ticket_query = "
                INSERT INTO tickets (user_id, ticket_type_id, second_key, security_code) 
                VALUES (?, ?, ?, ?)
            ";
            $stmt = $link->prepare($insert_ticket_query);
            $stmt->bind_param("iiss", $user_id, $ticket_type_id, $second_key, $security_code);
            $stmt->execute();
            $ticket_id = $stmt->insert_id;
            $stmt->close();

            // Enregistrer le paiement pour ce billet
            $insert_payment_query = "
                INSERT INTO payments (ticket_id, amount, payment_method) 
                VALUES (?, ?, ?)
            ";
            $stmt = $link->prepare($insert_payment_query);
            $payment_method = 'Card'; // Simuler le mode de paiement
            $stmt->bind_param("ids", $ticket_id, $details['price'], $payment_method);
            $stmt->execute();
            $stmt->close();

            // Appeler le script Python pour générer le PDF du billet
            // Ajouter un test pour vérifier l'exécution du script Python
            $command = escapeshellcmd("python C:/xampp/htdocs/paris-olympics-tickets/src/python/generate_ticket.py $ticket_id");
            $output = shell_exec($command);

            // Afficher la sortie pour le débogage
            echo "<pre>$output</pre>";

            // Gérer les erreurs dans le script Python
            if (!$output) {
                error_log("Erreur lors de la génération du billet pour le ticket ID: $ticket_id");
            }
        }
    }

    // Rediriger vers une page de confirmation ou l'espace utilisateur
    header('Location: /paris-olympics-tickets/public/espace_utilisateur.php?payment=success');
    exit();
} else {
    // En cas d'échec du paiement, rediriger vers la page de paiement avec un message d'erreur
    header('Location: /paris-olympics-tickets/public/payment.php?error=payment_failed');
    exit();
}
?>
