<?php

namespace Router\View;

use Framework312\Router\Request;
use Framework312\Router\View\ErrorView;
use Framework312\Template\TwigRenderer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class ErrorViewTest extends TestCase
{
    public function testRenderError401(): void
    {
        // Mock du TwigRenderer pour tester le rendu de l'erreur
        $twigRenderer = $this->createMock(TwigRenderer::class);
        $twigRenderer->method('render')->willReturn('<html><body>Erreur 401: Utilisateur non authentifié</body></html>');

        // Créer la vue d'erreur avec le code 404 et un message spécifique
        $errorView = new ErrorView($twigRenderer, Response::HTTP_NOT_FOUND, 'Erreur 401: Utilisateur non authentifié');

        // Rendre la réponse d'erreur
        $response = $errorView->render(new Request());

        // Assertions
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('<html><body>Erreur 401: Utilisateur non authentifié</body></html>', $response->getContent());
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testRenderError403(): void
    {
        // Mock du TwigRenderer pour tester le rendu de l'erreur
        $twigRenderer = $this->createMock(TwigRenderer::class);
        $twigRenderer->method('render')->willReturn('<html><body>Erreur 403: Accès interdit</body></html>');

        // Créer la vue d'erreur avec le code 404 et un message spécifique
        $errorView = new ErrorView($twigRenderer, Response::HTTP_NOT_FOUND, 'Erreur 403: Accès interdit');

        // Rendre la réponse d'erreur
        $response = $errorView->render(new Request());

        // Assertions
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('<html><body>Erreur 403: Accès interdit</body></html>', $response->getContent());
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
    public function testRenderError404(): void
    {
        // Mock du TwigRenderer pour tester le rendu de l'erreur
        $twigRenderer = $this->createMock(TwigRenderer::class);
        $twigRenderer->method('render')->willReturn('<html><body>Erreur 404: Page non trouvée</body></html>');

        // Créer la vue d'erreur avec le code 404 et un message spécifique
        $errorView = new ErrorView($twigRenderer, Response::HTTP_NOT_FOUND, 'Erreur 404: Page non trouvée');

        // Rendre la réponse d'erreur
        $response = $errorView->render(new Request());

        // Assertions
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('<html><body>Erreur 404: Page non trouvée</body></html>', $response->getContent());
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
    public function testRenderError500(): void
    {
        // Mock du TwigRenderer pour tester le rendu de l'erreur
        $twigRenderer = $this->createMock(TwigRenderer::class);
        $twigRenderer->method('render')->willReturn('<html><body>Erreur 500: Erreur interne du serveur</body></html>');

        // Créer la vue d'erreur avec le code 500 et un message spécifique
        $errorView = new ErrorView($twigRenderer, Response::HTTP_INTERNAL_SERVER_ERROR, 'Erreur 500: Erreur interne du serveur');

        // Rendre la réponse d'erreur
        $response = $errorView->render(new Request());

        // Assertions
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('<html><body>Erreur 500: Erreur interne du serveur</body></html>', $response->getContent());
        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }

    public function testRenderError502(): void
    {
        // Mock du TwigRenderer pour tester le rendu de l'erreur
        $twigRenderer = $this->createMock(TwigRenderer::class);
        $twigRenderer->method('render')->willReturn('<html><body>Erreur 502: Erreur de connexion</body></html>');

        // Créer la vue d'erreur avec le code 404 et un message spécifique
        $errorView = new ErrorView($twigRenderer, Response::HTTP_NOT_FOUND, 'Erreur 502: Erreur de connexion');

        // Rendre la réponse d'erreur
        $response = $errorView->render(new Request());

        // Assertions
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('<html><body>Erreur 502: Erreur de connexion</body></html>', $response->getContent());
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testRenderError503(): void
    {
        // Mock du TwigRenderer pour tester le rendu de l'erreur
        $twigRenderer = $this->createMock(TwigRenderer::class);
        $twigRenderer->method('render')->willReturn('<html><body>Erreur 503: Service non disponible</body></html>');

        // Créer la vue d'erreur avec le code 404 et un message spécifique
        $errorView = new ErrorView($twigRenderer, Response::HTTP_NOT_FOUND, 'Erreur 503: Service non disponible');

        // Rendre la réponse d'erreur
        $response = $errorView->render(new Request());

        // Assertions
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('<html><body>Erreur 503: Service non disponible</body></html>', $response->getContent());
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
