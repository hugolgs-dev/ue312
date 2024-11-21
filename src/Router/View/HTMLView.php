<<<<<<< HEAD
<?php declare(strict_types=1);

namespace Framework312\Router\View;

use Framework312\Router\Exception as RouterException;
use Framework312\Router\Request;
use Symfony\Component\HttpFoundation\Response;
=======
<?php

namespace Framework312\Router\View;

use Framework312\Router\Request;
use Framework312\Router\View\BaseView;
use Symfony\Component\HttpFoundation\Response;

class HTMLView extends BaseView
{
    // on indique si cette vue utilise ou non un moteur de template
    static public function use_template(): bool
    {
        // 'return true' car cette vuE utilise un moteur de template (Twig)
        return true;
    }

    // on génère et on renvoie une réponse HTTP avec un contenu HTML
    public function render(Request $request): Response
    {
        // On récupère la méthode HTTP utilisée dans la requête génèrée
        $method = strtolower($request->getMethod());

        // On vérifie que la méthode utilisée existe bien. Si c'est le cas, on pas à la suite
        if (!method_exists($this, $method)) {
            // Sinon, cela signifie que la méthode n'est pas implémentée ---> on lève une exception
            throw new \BadMethodCallException("La méthode HTTP [$method] n'existe pas.");
        }

        // On appelle la méthode correspondante à la requête et on récupère son contenu
        $data = $this->$method($request);

        // On retourne une réponse HTTP avec du contenu HTML et un type de contenu text/html
        return new Response($data, Response::HTTP_OK, ['Content-Type' => 'text/html']);
    }
}
>>>>>>> 083d0bc0bff4052680f242d7f3908543fe4466f0
