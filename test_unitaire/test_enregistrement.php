<?php

use PHPUnit\Framework\TestCase;

class test_enregistrement extends TestCase
{
    public function testenregistrement()
    {
        // Données de test
        $_POST = [
            'first_name' => 'marc',
            'last_name' => 'leo',
            'email' => 'marc.leo@example.com',
            'password' => 'codo123',
            'country' => 'France',
            'phone_number' => '2586558790'
        ];

        // Simulation de  la méthode POST
        $_SERVER['REQUEST_METHOD'] = 'POST';

        // Inclusion du fichier  register.php
        ob_start();
        require_once 'src/php/register.php';
        $output = ob_get_clean();

        // Vérifier si il y a des erreurs
        $this->assertStringNotContainsString('Erreur:', $output);
    }
}
