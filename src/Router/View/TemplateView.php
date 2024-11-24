<?php

namespace Framework312\Router\View;

use Framework312\Router\Request;
use Framework312\Router\View\BaseView;
use Symfony\Component\HttpFoundation\Response;
use Framework312\Template\TwigRenderer;

class TemplateView extends BaseView
{
    protected TwigRenderer $twigRenderer;
    // Hugo : j'ai du le passer en protected pour m'en servir dans ErrorView

    // Constructeur
    public function __construct(TwigRenderer $twigRenderer){

        $this->twigRenderer = $twigRenderer;

        // Enregistre la classe de la vue comme tag
        $this->twigRenderer->register(static::class);
    }
    static public function use_template(): bool
    {
        return true; // return true car cette vue utilise Twig
    }
    public function render(Request $request): Response
    {
        $method = strtolower($request->getMethod());

        // On vérifie que la méthode existe
        if(!method_exists($this, $method)){
            throw new \BadmethodCallException("La méthode HTTP [$method] n'existe pas.");
        }

        // On appelle la méthode
        $data = $this->$method($request);

        // Exception si les données retournées par la méthode n'est pas un tableau
        if(!is_array($data)){
            throw new \RuntimeException("Un tableau devrait être retourné par la méthode [$method]");
        }

        // Nom du template associé à l'extension du fichier Twig (ex: nom_template.html.twig)
        $template_name = str_replace('\\', '/',static::class . '.html.twig');

        $html_content = $this->twigRenderer->render($data, $template_name);

        // Retourne une réponse avec le contenu HTML généré
        return new Response($html_content);
    }
}