<?php

use PHPUnit\Framework\TestCase;
use Framework312\Template\TestRenderer; // Importer la classe TestRenderer
use Framework312\Router\SimpleRouter; // Importer la classe SimpleRouter
use Framework312\Template\Renderer;

class SimpleRouterTest extends TestCase {

    // Vérifie si le constructeur fonctionne correctement avec un Renderer valide
    public function testConstructorValidRenderer() {
        // Crée un objet TestRenderer valide
        $renderer = new TestRenderer();  
        // Crée un objet SimpleRouter avec le TestRenderer
        $router = new SimpleRouter($renderer);    

        // Vérifie que l'objet SimpleRouter a bien été créé
        $this->assertInstanceOf(SimpleRouter::class, $router);
    }

    // Vérifie si une exception est lancée lorsqu'on passe un objet invalide
    public function testConstructorInvalidRenderer() {
        // On s'attend à ce que l'erreur soit une TypeError
        $this->expectException(\TypeError::class);  

        // Crée un objet invalide (pas un Renderer)
        $invalidObject = new \stdClass();  
        // Essaie de créer un SimpleRouter avec un objet invalide
        new SimpleRouter($invalidObject);  // L'exception doit être lancée ici
    }
}
