<?php declare(strict_types=1);

namespace Framework312\Router\View;

use Framework312\Router\Exception as RouterException;
use Framework312\Router\Request;
use Framework312\Router\View\BaseView;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JSONView extends BaseView
{
    // on indique si cette vue utilise ou non un moteur de template (Twig)
    static public function use_template(): bool
    {
        // 'return false' car la vue n'a pas besoin d'utiliser Twig
        return false;
    }

    // on génère et on renvoie une réponse HTTP avec un contenu JSON
    public function render(Request $request): Response
    {
        // On récupère la méthode HTTP utilisée dans la requête génèrée
        $method = strtolower($request->getMethod());

        // On vérifie que la méthode utilisée existe bien. Si c'est le cas, on pas à la suite
        if(!method_exists($this, $method)) {
            // Sinon, cela signifie que la méthode n'est pas implémentée ---> on lève une exception
            throw new \BadMethodCallException("La méthode HTTP [$method] n'existe pas.");
        }

        // On appelle la méthode correspondante à la requête et on récupère son contenu
        $data = $this->$method($request);

        // On retourne une réponse JSON avec les données dans ce format et un type 'application/json'
        // => ce type est déjà géré par 'JsonResponse', donc pas besoin de le préciser
        return new JsonResponse($data, Response::HTTP_OK);
    }
}

