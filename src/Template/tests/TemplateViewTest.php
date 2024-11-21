<?php

use PHPUnit\Framework\TestCase;
use Framework312\Router\Request;
use Framework312\Router\View\TemplateView;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as TwigRenderer;

class TemplateViewTest extends TestCase {

    public function testRenderReturnTemplateView() : void
    {
        $request = new Request();

        $view = new class extends TemplateView {
            protected function get(Request $request): array
            {
                return ['status' => 'ok', 'message' => 'ok'];
            }
        };

        $response = $view->render($request);

        // Assertions
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('<html><body>Ça fonctionne!</body></html>', $response->getContent());
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}