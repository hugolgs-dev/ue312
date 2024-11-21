<?php

use PHPUnit\Framework\TestCase;
use Framework312\Template\TwigRenderer;

class TwigRendererTest extends TestCase
{
    public function testConstructorInitializesTwig()
    {
        // Chemin temporaire pour les templates
        $templatePath = __DIR__ . '/templates';

        // Crée un dossier de test pour les templates
        if (!is_dir($templatePath)) {
            mkdir($templatePath);
        }

        // Crée un fichier template de test
        $templateFile = $templatePath . '/test.twig';
        file_put_contents($templateFile, '{{ message }}');

        // Initialise TwigRenderer avec le chemin
        $renderer = new TwigRenderer($templatePath);

        // Vérifie si l'objet $twig est bien une instance de Twig\Environment
        $this->assertInstanceOf(\Twig\Environment::class, $renderer->getTwig());

        // Nettoyage après le test
        unlink($templateFile); // Supprime le fichier template
        rmdir($templatePath);  // Supprime le dossier de test
    }
}
