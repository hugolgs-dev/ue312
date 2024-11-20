<?php declare(strict_types=1);

namespace Framework312\Template;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRenderer implements Renderer
{
    private Environment $twig;

    public function __construct(string $templatePath)
    {
        // TODO: Initialiser l'instance de Twig (Environment et FilesystemLoader).
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
