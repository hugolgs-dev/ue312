<?php

use PHPUnit\Framework\TestCase;
use Framework312\Router\Request;
use Framework312\Router\View\JSONView;
use Symfony\Component\HttpFoundation\JsonResponse;

class JSONViewTest extends TestCase {
    public function testRenderReturnJsonResponse(): void
    {
        // On crée une instance de requête
        $request = new Request();

        // On crée une vue JSONView, avec une méthode get pour le test
        $view = new class() extends JSONView {
            protected function get(Request $request): array
            {
                // Contenu de la vue crée pour le test
                return ['status' => 'ok', 'message' => 'ok'];
            }
        };

        // On appelle la méthode "render"
        $response = $view->render($request);

        /* Asserions */

        // On vérifie que la réponse est bien une instance de Response
        $this->assertInstanceOf(JsonResponse::class, $response);

        // On vérifie le type de la réponse, qui doit être application/json ici
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));

        // On vérifie le contenu de la réponse en 2 étapes :

            // on traduit la réponse, sous forme de tableau, en chaîne JSON avec json_encode
        $expectedContent = json_encode(['status' => 'ok', 'message' => 'ok']);
            // on vérifie que le contenu retourné est correctement convertie en JSON, donc valide avec le format de données attendu
        $this->assertEquals($expectedContent, $response->getContent());

        // On vérifie que le statut de la requête est bien 200
        $this->assertEquals(200, $response->getStatusCode());

    }
}