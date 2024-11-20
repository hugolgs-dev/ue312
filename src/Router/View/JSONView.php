<?php

namespace Framework312\Router\View;

use Framework312\Router\Request;
use Framework312\Router\View\BaseView;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JSONView extends BaseView
{

    static public function use_template(): bool
    {
        // return false car la vue n'utilise pas TWIG
        return false;
    }

    public function render(Request $request): Response
    {
        $method = strtolower($request->getMethod());

        if(!method_exists($this, $method)) {
            throw new \BadMethodCallException("La méthode HTTP [$method] n'existe pas.");
        }

        $data = $this->$method($request);

        return new JsonResponse($data, Response::HTTP_OK);
    }
}