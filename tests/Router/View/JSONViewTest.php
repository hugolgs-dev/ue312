<?php

use PHPUnit\Framework\TestCase;
use Framework312\Router\Request;
use Framework312\Router\View\JSONView;
use Symfony\Component\HttpFoundation\JsonResponse;

class JSONViewTest extends TestCase {
    public function testRenderReturnJsonResponse(): void
    {
        $request = new Request();

        $view = new class() extends JSONView {
            protected function get(Request $request): array
            {
                return ['status' => 'ok', 'message' => 'ok'];
            }
        };

        $response = $view->render($request);

        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertEquals('application/json', $response->headers->get('Content-Type'));

        $expectedContent = json_encode(['status' => 'ok', 'message' => 'ok']);
        $this->assertEquals($expectedContent, $response->getContent());

        $this->assertEquals(200, $response->getStatusCode());

    }
}