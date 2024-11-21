<?php

namespace Router\View;

use Framework312\Router\Request;
use Framework312\Router\View\TemplateView;
use Framework312\Template\TwigRenderer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class TemplateViewTest extends TestCase
{

    public function testRenderReturnTemplateView(): void
    {
        $request = new Request();

        $twigRenderer = $this->createMock(TwigRenderer::class);
        $twigRenderer->method('render')->willReturn('<html><body>Ça fonctionne!</body></html>');

        //$view = new class extends TwigRenderer {
        $view = new class($twigRenderer) extends TemplateView {
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