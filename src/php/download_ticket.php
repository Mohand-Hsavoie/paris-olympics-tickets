<?php
// Chemin du fichier à télécharger (mettre à jour si nécessaire)
$file = 'C:/xampp/htdocs/paris-olympics-tickets/src/tickets/ticket_' . $_GET['ticket_id'] . '.pdf';

// Vérifie si le fichier existe
if (file_exists($file)) {
    // Définir les en-têtes pour forcer le téléchargement
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    
    // Lire le fichier et le transmettre au client
    readfile($file);
    exit;
} else {
    echo "Le fichier n'existe pas.";
}
?>
