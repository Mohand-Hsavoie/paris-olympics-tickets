<?php
session_start();

// Vérifier si le panier et le montant total existent
if (!isset($_SESSION['cart'], $_SESSION['total_amount'])) {
    header('Location: /paris-olympics-tickets/public/billetterie.php');
    exit();
}

// Récupérer les informations du panier
$cart = $_SESSION['cart'];
$totalAmount = $_SESSION['total_amount'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement</title>
    <link rel="stylesheet" href="css/payement.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> <!-- Bootstrap -->
</head>
<body>
    <div class="container mt-5">
        <h1>Paiement</h1>
        <h2>Détails de votre commande</h2>
        <ul class="list-group">
            <?php foreach ($cart as $item => $details): ?>
                <li class="list-group-item">
                    <?php echo ucfirst($item); ?> - Quantité: <?php echo $details['quantity']; ?> - Prix unitaire: <?php echo $details['price']; ?> €
                </li>
            <?php endforeach; ?>
        </ul>
        <h3 class="mt-3">Montant total: <?php echo $totalAmount; ?> €</h3>
        
        <!-- Formulaire de paiement -->
        <form id="payment-form" action="/paris-olympics-tickets/src/php/process_payment.php" method="POST" class="mt-4">
            <div class="form-group">
                <label for="card_number">Numéro de carte :</label>
                <input type="text" class="form-control" id="card_number" name="card_number" required minlength="16" maxlength="16">
            </div>

            <div class="form-group">
                <label for="expiry_date">Date d'expiration :</label>
                <input type="text" class="form-control" id="expiry_date" name="expiry_date" required placeholder="MM/AA">
            </div>

            <div class="form-group">
                <label for="cvv">CVV :</label>
                <input type="text" class="form-control" id="cvv" name="cvv" required minlength="3" maxlength="4">
            </div>

            <button type="submit" class="btn btn-primary">Valider le paiement</button>
        </form>
    </div>

    <!-- Inclure les fichiers JS de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
