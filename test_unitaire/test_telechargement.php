<?php

use PHPUnit\Framework\TestCase;

class test_telechargement extends TestCase
{
    public function testFileExists()
    {
        // Simuler les données GET
        $_GET['ticket_id'] = '123';

        // Chemin du fichier à télécharger
        $file = 'var/www/html/paris-olympics-tickets/src/tickets/ticket_' . $_GET['ticket_id'] . '.pdf';

        // Créer un fichier temporaire pour le test
        file_put_contents($file, 'Test content');

        // Capturer les en-têtes HTTP
        ob_start();
        require_once 'src/php/download.php';
        $output = ob_get_clean();

        // Récupérer les en-têtes HTTP
        $headers = headers_list();

        // Vérifier que le fichier est téléchargé
        $this->assertContains('Content-Disposition: attachment; filename="ticket_123.pdf"', $headers);

        // Supprimer le fichier temporaire
        unlink($file);
    }

    public function testFileDoesNotExist()
    {
        // Simuler les données GET
        $_GET['ticket_id'] = '456';

        // Chemin du fichier à télécharger
        $file = 'var/www/html/paris-olympics-tickets/src/tickets/ticket_' . $_GET['ticket_id'] . '.pdf';

        // Capturer la sortie
        ob_start();
        require_once 'src/php/download.php';
        $output = ob_get_clean();

        // Vérifier que le message d'erreur est affiché
        $this->assertStringContainsString('Le fichier n\'existe pas.', $output);
    }
}
