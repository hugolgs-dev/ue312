<?php

use PHPUnit\Framework\TestCase;
use Framework312\Router\Request;
use Framework312\Router\View\HTMLView;
use Symfony\Component\HttpFoundation\Response;

class HTMLViewTest extends TestCase {
    public function testRenderReturnHtmlResponse(): void
    {
        $request = new Request();

        $view = new class() extends HTMLView {
            protected function get(Request $request): string
            {
                return '<html><body>Ça fonctionne!</body></html>';
            }
        };

        $response = $view->render($request);

        $this->assertInstanceOf(Response::class, $response);

        $this->assertEquals('text/html', $response->headers->get('Content-Type'));

        $this->assertEquals('<html><body>Ça fonctionne!</body></html>', $response->getContent());

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}