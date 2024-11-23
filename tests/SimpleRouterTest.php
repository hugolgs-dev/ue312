<?php

use PHPUnit\Framework\TestCase;
use Framework312\Template\TestRenderer; // Importer la classe TestRenderer
use Framework312\Router\SimpleRouter; // Importer la classe SimpleRouter
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    public function testCallMethodReturnsResponse()
    {
        // Créer une classe anonyme qui étend BaseView
        $mockViewClass = new class extends \Framework312\Router\View\BaseView {
            // Implémentation de la méthode abstraite 'render'
            public function render(\Framework312\Router\Request $request): \Symfony\Component\HttpFoundation\Response
            {
                // Retourner un objet Response avec du contenu HTML
                return new \Symfony\Component\HttpFoundation\Response("<h1>Rendered Content</h1>");
            }
    
            // Implémentation de la méthode abstraite 'use_template'
            public static function use_template(): bool
            {
                return true; // Pour le test, on retourne simplement 'true'
            }
        };
    
        // Créer une instance de Request (assurez-vous que la classe Request est correctement incluse)
        $request = new \Framework312\Router\Request();
    
        // Créer une instance de Renderer fictif (on ne l'utilise pas ici, mais il faut le passer)
        $mockRenderer = $this->createMock(\Framework312\Template\Renderer::class);
    
        // Créer une instance de Route avec la classe anonyme comme vue
        $route = new \Framework312\Router\Route(get_class($mockViewClass));
    
        // Appeler la méthode 'call' sur la route avec la requête et le renderer
        $response = $route->call($request, $mockRenderer);
    
        // Vérifier que la méthode call retourne bien une instance de Response
        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\Response::class, $response);
    
        // Vérifier que le contenu de la réponse est celui attendu
        $this->assertEquals("<h1>Rendered Content</h1>", $response->getContent());
    }
    
    public function testRegisterValidRoute()
    {
        // Création d'un mock de la classe Renderer
        $renderer = $this->createMock(\Framework312\Template\Renderer::class);

        // Initialisation du SimpleRouter avec le mock du renderer
        $router = new SimpleRouter($renderer);

        // Crée une classe anonyme qui étend BaseView
        $mockViewClass = new class extends \Framework312\Router\View\BaseView {
            // Implémentation de la méthode abstraite 'render'
            public function render(\Framework312\Router\Request $request): \Symfony\Component\HttpFoundation\Response
            {
                return new \Symfony\Component\HttpFoundation\Response("Test content");
            }

             // Implémentation de la méthode 'render' pour retourner une réponse
            public static function use_template(): bool
            {
                return false;
            }
        };

        // Appelle la méthode `register` avec un chemin et une classe valide
        $router->register('/test-route', $mockViewClass);

        // Accède à la propriété privée `$routes` pour vérifier l'enregistrement
        $reflection = new \ReflectionClass($router);
        $routesProperty = $reflection->getProperty('routes');
        $routesProperty->setAccessible(true);

        // Vérifie que la route est bien enregistrée
        $routes = $routesProperty->getValue($router);
        $this->assertArrayHasKey('/test-route', $routes);
        $this->assertInstanceOf(\Framework312\Router\Route::class, $routes['/test-route']);
    }
    public function testServe()
    {
        // Crée un mock pour le renderer
        $renderer = $this->createMock(\Framework312\Template\Renderer::class);

        // Initialisation du SimpleRouter avec le mock du renderer
        $router = new SimpleRouter($renderer);

        // Crée une classe anonyme pour simuler une vue
        $mockViewClass = new class extends \Framework312\Router\View\BaseView {
            public function render(\Framework312\Router\Request $request): \Symfony\Component\HttpFoundation\Response
            {
                return new \Symfony\Component\HttpFoundation\Response("Test content");
            }

            public static function use_template(): bool
            {
                return false;
            }
        };

        // Enregistre une route
        $router->register('/test-route', $mockViewClass);

        // Simulation d'une requête HTTP
        $_SERVER['REQUEST_URI'] = '/test-route';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        // Capture la sortie générée par la méthode `serve`
        ob_start();
        $router->serve();
        $output = ob_get_clean();

        // Vérification que la réponse 
        $this->assertStringContainsString('Test content', $output, "Le contenu de la réponse n'est pas celui attendu.");
    }




}

