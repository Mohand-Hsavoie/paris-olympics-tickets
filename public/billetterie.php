<?php
require_once ('../src/php/config.php');
session_start();
// Vérifier la connexion
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}
// Requête pour obtenir les types de tickets et leurs prix
$sql = "SELECT name, price FROM ticket_types";
$result = $link->query($sql);
$ticketPrices = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ticketPrices[$row['name']] = $row['price'];
    }
}

// Fermer la connexion à la base de données
$link->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billetterie</title>
    <link rel="stylesheet" href="/paris-olympics-tickets/public/css/style_billetterie.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Conteneur pour le menu -->
<div id="menu-container"></div>

<!-- Conteneur pour les produits -->
<div class="container mt-5">
    <div id="solo" class="product-container">
        <h3>Billet Solo</h3>
        <button onclick="updateQuantity('solo', 'minus')">-</button>
        <span id="quantity-solo">0</span>
        <button onclick="updateQuantity('solo', 'plus')">+</button>
        <span id="price-solo">0 €</span>
    </div>
    <div id="duo" class="product-container mt-3">
        <h3>Billet Duo</h3>
        <button onclick="updateQuantity('duo', 'minus')">-</button>
        <span id="quantity-duo">0</span>
        <button onclick="updateQuantity('duo', 'plus')">+</button>
        <span id="price-duo">0 €</span>
    </div>

    <div id="famille" class="product-container mt-3">
        <h3>Billet Famille</h3>
        <button onclick="updateQuantity('famille', 'minus')">-</button>
        <span id="quantity-famille">0</span>
        <button onclick="updateQuantity('famille', 'plus')">+</button>
        <span id="price-famille">0 €</span>
    </div>
    <div class="total-container">
        Total à payer : <span id="total-price" class="total-price">0 €</span>
    </div>
    <!-- Formulaire caché pour soumettre le panier -->
<form id="cart-form" action="../src/php/process_cart.php" method="POST" style="display: none;">
    <input type="hidden" name="solo_quantity" id="solo_quantity" value="0">
    <input type="hidden" name="duo_quantity" id="duo_quantity" value="0">
    <input type="hidden" name="famille_quantity" id="famille_quantity" value="0">
    <input type="hidden" name="total_amount" id="total_amount" value="0">  
</form>
<div class="validate-button">
        <button type="button" class="btn btn-primary" onclick="validateSelection()">Valider le panier</button>
    </div>  
<!-- Scripts JS de Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Script pour le chargement dynamique du menu -->
<script>
    fetch('menu.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('menu-container').innerHTML = data;
        });
</script>
<script>
    window.ticketPrices = <?php echo json_encode($ticketPrices); ?>;
</script>
<script src="js/billetterie.js"></script>
</body>
</html>