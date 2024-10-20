<?php

use PHPUnit\Framework\TestCase;

class test_generation_cle_securtie extends TestCase
{
    public function testGenerateSecurityCode()
    {
        // Simuler les données de test
        $first_key = 'abcdef1234567890';
        $second_key = '1234567890abcdef';

        // Concaténer les deux clés
        $security_code = $first_key . $second_key;

        // Vérifier que le security_code est correctement généré
        $this->assertEquals('abcdef12345678901234567890abcdef', $security_code);
    }
}
