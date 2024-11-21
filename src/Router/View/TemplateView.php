<?php

namespace Framework312\Router\View;

use Framework312\Router\Request;
use Framework312\Router\View\BaseView;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as TwigRenderer;

class TemplateView extends BaseView
{

    private TwigRenderer $twigRenderer;

    // Constructeur
    public function __construct(TwigRenderer $twigRenderer){

        $this->twigRenderer = $twigRenderer;

        $this->twigRenderer->addGlobal('view_class', static::class);
    }
    static public function use_template(): bool
    {
        return true; // return true car cette vue utilise les templates TWIG
    }

    public function render(Request $request): Response
    {
        $method = strtolower($request->getMethod());

        if(!method_exists($this, $method)){
            throw new \BadmethodCallException("La méthode HTTP [$method] n'existe pas.");
        }

        $data = $this->$method($request);

        // Exception si les données retournées par la méthode n'est pas un tableau
        if(!is_array($data)){
            throw new \RuntimeException("Un tableau devrait être retourné par la méthode [$method]");
        }

        // Nom du template
        $template_name = str_replace('\\', '/',static::class . '.html.twig');

        $html_content = $this->twigRenderer->render($template_name, $data);

        // Retourne une réponse avec le contenu HTML généré
        return new Response($html_content);
    }



}