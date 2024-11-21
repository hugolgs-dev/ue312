<?php declare(strict_types=1);

namespace Framework312\Router;

use Framework312\Router\Exception as RouterException;
use Framework312\Template\Renderer;
use Symfony\Component\HttpFoundation\Response;

class Route
{
    private const VIEW_CLASS = 'Framework312\Router\View\BaseView';
    private const VIEW_USE_TEMPLATE_FUNC = 'use_template';
    private const VIEW_RENDER_FUNC = 'render';

    private string $view;

    public function __construct(string|object $class_or_view)
    {
        $reflect = new \ReflectionClass($class_or_view);
        $view = $reflect->getName();
        if (!$reflect->isSubclassOf(self::VIEW_CLASS)) {
            throw new RouterException\InvalidViewImplementation($view);
        }
        $this->view = $view;
    }

    public function call(Request $request, ?Renderer $engine): Response
{
    // Vérifie si la classe existe et si elle est une sous-classe de BaseView
    $reflect = new \ReflectionClass($this->view);

    if (!$reflect->isSubclassOf(self::VIEW_CLASS)) {
        throw new \RuntimeException("La classe {$this->view} doit hériter de " . self::VIEW_CLASS);
    }

    // Crée une instance de la vue
    $viewInstance = new $this->view();

    // Vérifie que la méthode render existe
    if (!method_exists($viewInstance, self::VIEW_RENDER_FUNC)) {
        throw new \RuntimeException("La vue {$this->view} doit implémenter la méthode " . self::VIEW_RENDER_FUNC);
    }

    // Appelle la méthode render et récupère le contenu
    $content = $viewInstance->{self::VIEW_RENDER_FUNC}($request);

    // Si le contenu est déjà une instance de Response, on la retourne directement
    if ($content instanceof Response) {
        return $content;
    }

    // Crée et retourne la réponse HTTP avec le contenu
    return new Response($content);
}

    
}

class SimpleRouter implements Router
{
    private Renderer $engine; //propriété

    public function __construct(Renderer $engine)
    {
        // On vérifie que l'objet passé ($engine) est bien une instance de la classe Renderer
        $reflect = new \ReflectionClass($engine);
        $engineClass = $reflect->getName();

        // Si l'objet n'est pas une sous-classe de Renderer, on lance une exception pour signaler l'erreur
        if (!$reflect->isSubclassOf(Renderer::class)) {
            throw new \InvalidArgumentException("L'objet passé doit être une instance de Renderer, mais c'est une instance de $engineClass.");
        }

        // Si tout est correct, on enregistre l'objet Renderer dans une propriété pour l'utiliser dans la classe
        $this->engine = $engine;
    }

    // Enregistre une route avec une vue ou un contrôleur.
    public function register(string $path, string|object $class_or_view)
    {
        // TODO
    }
    // Exécute l'action associée à une route
    public function serve(mixed ...$args): void
    {
        // TODO
    }
}

?>
