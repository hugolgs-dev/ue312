<?php

namespace Framework312\Router\View;

use Framework312\Router\Request;
use Symfony\Component\HttpFoundation\Response;
use Framework312\Template\TwigRenderer;
use Framework312\Router\View\TemplateView;

class ErrorView extends TemplateView
{
    // Messages d'erreurs - à modifier si besoin
    private array $errors = [
        401 => 'Erreur 401: Utilisateur non authentifié',
        403 => 'Erreur 403: Accès interdit',
        404 => 'Erreur 404: Page non trouvée',
        500 => 'Erreur 500: Erreur interne du serveur',
        502 => 'Erreur 502: Erreur de connexion',
        503 => 'Erreur 503: Service non disponible',
    ];

    // Variables pour stocker l'erreur HTTP rencontrée et son message associé
    private int $statusCode;
    private string $message;

    // Constructeur qui associe ces variables aux données générées par l'erreur HTTP
    public function __construct(TwigRenderer $twigRenderer, int $statusCode, ?string $message){

        parent::__construct($twigRenderer);

        $this->statusCode = $statusCode;
        $this->message = $message ?? $this->errors[$this->statusCode] ?? 'Erreur inconnue';
    }

    // Fonctionne qui génère le contenu HTML pour ensuite l'envoyer vers le fichier Twig
    public function render(Request $request): Response
    {

        $html_content = $this->twigRenderer->render(
            [
                'code' => $this->statusCode,
                'message' => $this->message,
            ],
            'errors/error.html.twig'
        );

        // Réponse générée avec le contenu HTML
        return new Response($html_content, $this->statusCode);
    }
}