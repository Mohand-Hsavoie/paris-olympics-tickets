<?php

use PHPUnit\Framework\TestCase;

class test_validationpanier extends TestCase
{
    protected function setUp(): void
    {
        // Démarrer la session
        session_start();
    }

    protected function tearDown(): void
    {
        // Détruire la session
        session_destroy();
    }

    public function testCartValidationSuccess()
    {
        // Simuler les données de session pour l'authentification
        $_SESSION['authenticated'] = true;

        // Simuler les données du formulaire
        $_POST = [
            'solo_quantity' => '2',
            'duo_quantity' => '1',
            'famille_quantity' => '3',
            'total_amount' => '123.45'
        ];

        // Inclure le fichier de validation du panier
        ob_start();
        require_once 'src/php/cart_validation.php';
        $output = ob_get_clean();

        // Vérifier que les informations du panier sont correctement stockées dans la session
        $this->assertArrayHasKey('cart', $_SESSION);
        $this->assertArrayHasKey('total_amount', $_SESSION);
        $this->assertEquals(2, $_SESSION['cart']['solo']['quantity']);
        $this->assertEquals(1, $_SESSION['cart']['duo']['quantity']);
        $this->assertEquals(3, $_SESSION['cart']['famille']['quantity']);
        $this->assertEquals(123.45, $_SESSION['total_amount']);
    }

    public function testCartValidationFailure()
    {
        // Simuler les données de session pour l'authentification
        $_SESSION['authenticated'] = true;

        // Simuler les données du formulaire avec des valeurs invalides
        $_POST = [
            'solo_quantity' => 'abc',
            'duo_quantity' => '1',
            'famille_quantity' => '3',
            'total_amount' => '123.45'
        ];

        // Inclure le fichier de validation du panier
        ob_start();
        require_once 'src/php/cart_validation.php';
        $output = ob_get_clean();

        // Vérifier que le message d'erreur est affiché
        $this->assertStringContainsString('Données de panier invalides.', $output);
    }

    public function testCartValidationUnauthenticated()
    {
        // Simuler les données de session pour l'authentification
        $_SESSION['authenticated'] = false;

        // Simuler les données du formulaire
        $_POST = [
            'solo_quantity' => '2',
            'duo_quantity' => '1',
            'famille_quantity' => '3',
            'total_amount' => '123.45'
        ];

        // Capturer les en-têtes HTTP
        ob_start();
        require_once 'src/php/cart_validation.php';
        $output = ob_get_clean();

        // Récupérer les en-têtes HTTP
        $headers = headers_list();

        // Vérifier la redirection vers la page d'authentification
        $this->assertContains('Location: /paris-olympics-tickets/public/authentification.html', $headers);
    }
}

