<?php

use PHPUnit\Framework\TestCase;
use Framework312\Router\Request;
use Framework312\Router\View\HTMLView;
use Symfony\Component\HttpFoundation\Response;

class HTMLViewTest extends TestCase {
    public function testRenderReturnHtmlResponse(): void
    {
        // On crée une instance de requête
        $request = new Request();

        // On crée une vue HTMLView, avec une méthode get pour le test
        $view = new class() extends HTMLView {
            protected function get(Request $request): string
            {
                // Contenu de la vue crée pour le test
                return '<html><body>Ça fonctionne!</body></html>';
            }
        };

        // On appelle la méthode "render"
        $response = $view->render($request);

        /* Assertions */

        // On vérifie que la réponse est une instance de Response
        $this->assertInstanceOf(Response::class, $response);

        // On vérifie le type de la réponse, qui doit être text/html ici
        $this->assertEquals('text/html', $response->headers->get('Content-Type'));

        // On vérifie que le contenu de la réponse est valide par rapport au format attendu
        $this->assertEquals('<html><body>Ça fonctionne!</body></html>', $response->getContent());

        // On vérifie que le statut de la requête HTTP est bien 200
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}