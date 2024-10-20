<?php

use PHPUnit\Framework\TestCase;

class test_login extends TestCase
{
    protected $link;

    protected function setUp(): void
    {
        // Initialiser la connexion à la base de données (simulée)
        $this->link = $this->getMockBuilder(mysqli::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Simuler la méthode prepare
        $stmt = $this->getMockBuilder(mysqli_stmt::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stmt->method('bind_param')->willReturn(true);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('store_result')->willReturn(true);
        $stmt->method('num_rows')->willReturn(1);
        $stmt->method('bind_result')->willReturn(true);
        $stmt->method('fetch')->willReturn(true);
        $stmt->method('close')->willReturn(true);

        $this->link->method('prepare')->willReturn($stmt);
    }

    protected function tearDown(): void
    {
        // Fermer la connexion
        $this->link->close();
    }

    public function testUserLoginSuccess()
    {
        // Données de test
        $_POST = [
            'email' => 'john.doe@example.com',
            'password' => 'password123'
        ];

        // Simuler la méthode POST
        $_SERVER['REQUEST_METHOD'] = 'POST';

        // Simuler les données de l'utilisateur
        $id = 1;
        $first_name = 'mickael';
        $email = 'mickeal@example.com';
        $hashed_password = password_hash('password123', PASSWORD_DEFAULT);

        // Simuler la récupération des données de l'utilisateur
        $stmt = $this->link->prepare("SELECT id, first_name, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $first_name, $email, $hashed_password);
        $stmt->fetch();
        $stmt->close();

        // Inclure le fichier login.php
        ob_start();
        require_once 'src/php/login.php';
        $output = ob_get_clean();

        // Vérifier que l'utilisateur est connecté avec succès
        $this->assertArrayHasKey('user_id', $_SESSION);
        $this->assertArrayHasKey('first_name', $_SESSION);
        $this->assertArrayHasKey('email', $_SESSION);
        $this->assertArrayHasKey('authenticated', $_SESSION);
        $this->assertEquals(1, $_SESSION['user_id']);
        $this->assertEquals('mikael', $_SESSION['first_name']);
        $this->assertEquals('mickeal@example.com', $_SESSION['email']);
        $this->assertTrue($_SESSION['authenticated']);

        // Vérifier la redirection
        $this->assertStringContainsString('Location: /paris-olympics-tickets/public/espace_utilisateur.php', xdebug_get_headers());
    }

    public function testUserLoginFailure()
    {
        // Données de test
        $_POST = [
            'email' => 'mickael@example.com',
            'password' => 'wrongpassword'
        ];

        // Simuler la méthode POST
        $_SERVER['REQUEST_METHOD'] = 'POST';

        // Simuler les données de l'utilisateur
        $id = 1;
        $first_name = 'mickael';
        $email = 'mickael@example.com';
        $hashed_password = password_hash('password123', PASSWORD_DEFAULT);

        // Simuler la récupération des données de l'utilisateur
        $stmt = $this->link->prepare("SELECT id, first_name, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $first_name, $email, $hashed_password);
        $stmt->fetch();
        $stmt->close();

        // Inclure le fichier login.php
        ob_start();
        require_once 'src/php/login.php';
        $output = ob_get_clean();

        // Vérifier que l'utilisateur n'est pas connecté
        $this->assertStringContainsString('Mot de passe incorrect.', $output);
    }
}
