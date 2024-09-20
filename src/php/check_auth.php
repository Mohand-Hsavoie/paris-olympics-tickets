<?php
session_start();

// controle si l'utilisateur est authentifié en vérifiant la présence de 'user_id' dans la session
$isAuthenticated = isset($_SESSION['user_id']);
// Préparer une réponse JSON
$response = array('authenticated' => $isAuthenticated);
// Renvoyer la réponse JSON
header('Content-Type: application/json');
echo json_encode($response);
?>

