<?php declare(strict_types=1);

namespace Framework312\Template;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRenderer implements Renderer
{
    private Environment $twig;

    //Initialise Twig avec le chemin des fichiers templates
    public function __construct(string $templatePath)
    {
        // Charger les fichiers de template depuis $templatePath
        $loader = new FilesystemLoader($templatePath);

        // Initialiser Twig avec ce chargeur
        $this->twig = new Environment($loader);
    }

    // SERT UNIQUEMENT POUR TESTER CONSTRUCT
    public function getTwig(): \Twig\Environment
    {
        return $this->twig;
    }

    public function render(mixed $data, string $template): string
    {
        // TODO: Utiliser l'instance de Twig pour rendre le template avec les données.
    }

    public function register(string $tag): void
    {
        // TODO: Ajouter un chemin ou alias au moteur Twig pour qu'il puisse localiser les templates.
    }
}
?>
