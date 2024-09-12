<?php
session_start();

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: /paris-olympics-tickets/public/authentification.html');
    exit();
}

// Vérifier et valider les données du formulaire
$expectedFields = ['solo_quantity', 'duo_quantity', 'famille_quantity', 'total_amount'];
foreach ($expectedFields as $field) {
    if (!isset($_POST[$field]) || !is_numeric($_POST[$field])) {
        die("Données de panier invalides.");
    }
}

// Récupérer les données du formulaire
$soloQuantity = (int) $_POST['solo_quantity'];
$duoQuantity = (int) $_POST['duo_quantity'];
$familleQuantity = (int) $_POST['famille_quantity'];
$totalAmount = (float) $_POST['total_amount'];

// Vérifier la validité des quantités et du montant total
if ($totalAmount <= 0) {
    die("Montant total invalide.");
}

// Stocker les informations du panier dans la session
$_SESSION['cart'] = [
    'solo' => ['quantity' => $soloQuantity, 'price' => 15],
    'duo' => ['quantity' => $duoQuantity, 'price' => 28],
    'famille' => ['quantity' => $familleQuantity, 'price' => 42],
];
$_SESSION['total_amount'] = $totalAmount;

// Rediriger vers la page de paiement
header('Location: /paris-olympics-tickets/public/payment.php');
exit();
