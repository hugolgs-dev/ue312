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

    //Rend un template avec les données passées en argument
    public function render(mixed $data, string $template): string
    {
        try {
            // Utilisation de Twig pour charger et rendre le template avec les données
            return $this->twig->render($template, (array) $data);
        } catch (\Twig\Error\LoaderError $e) {
            throw new \RuntimeException("Erreur de chargement du template : {$e->getMessage()}", 0, $e);
        } catch (\Twig\Error\RuntimeError $e) {
            throw new \RuntimeException("Erreur à l'exécution du template : {$e->getMessage()}", 0, $e);
        } catch (\Twig\Error\SyntaxError $e) {
            throw new \RuntimeException("Erreur de syntaxe dans le template : {$e->getMessage()}", 0, $e);
        }
    }

    //Enregistre un alias pour un dossier de templates
    public function register(string $tag): void
    {
        try {
            //Ajoute un dossier à Twig pour qu'il puisse trouver les templates
            //On utilise le tag comme nom du dossier (alias)
            $this->twig->getLoader()->addPath('./templates/' . $tag, $tag);
        } catch (\Exception $e) {
            // Si ça échoue, on capte l'erreur et on affiche un message
            throw new \RuntimeException("Impossible d'enregistrer le chemin ou l'alias : " . $e->getMessage());
        }
    }

}
?>
