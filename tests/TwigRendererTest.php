<?php

use PHPUnit\Framework\TestCase;
use Framework312\Template\TwigRenderer;

class TwigRendererTest extends TestCase
{
    public function testConstructorInitializesTwig()
    {
        //Spécifie un dossier temporaire pour les templates
        $templatePath = __DIR__ . DIRECTORY_SEPARATOR . 'templates';

        //Crée le dossier de test s'il n'existe pas
        if (!is_dir($templatePath)) {
            mkdir($templatePath);
        }

        //Crée un sous-dossier "sub" pour y mettre un fichier de test
        $subFolder = $templatePath . DIRECTORY_SEPARATOR . 'sub';
        if (!is_dir($subFolder)) {
            mkdir($subFolder); // Crée le sous-dossier "sub" s'il n'existe pas
        }

        //Crée un fichier template "test.twig" dans le sous-dossier
        $templateFile = $subFolder . DIRECTORY_SEPARATOR . 'test.twig';
        file_put_contents($templateFile, '{{ message }}'); // Ajoute un contenu de test

        //Initialise TwigRenderer avec le chemin des templates
        $renderer = new TwigRenderer($templatePath);

        //Vérifie si l'objet TwigRenderer est bien une instance de \Twig\Environment
        $this->assertInstanceOf(\Twig\Environment::class, $renderer->getTwig());

        // Nettoie tout après le test
        unlink($templateFile); // Supprime le fichier template
        rmdir($subFolder);     // Supprime le sous-dossier "sub"
        $this->deleteDirectory($templatePath);  // Supprime tout le dossier "templates" et son contenu
    }


    public function testRenderWithValidData()
    {
        //Crée un dossier temporaire pour les templates
        $templatePath = __DIR__ . DIRECTORY_SEPARATOR . 'templates';
        if (!is_dir($templatePath)) {
            mkdir($templatePath);
        }

        //Crée un fichier template de test
        $templateFile = $templatePath . DIRECTORY_SEPARATOR . 'test.twig';
        file_put_contents($templateFile, '<h1>{{ title }}</h1><p>{{ content }}</p>');

        //Initialise TwigRenderer avec le chemin
        $renderer = new TwigRenderer($templatePath);

        //Données à injecter dans le template
        $data = ['title' => 'Bienvenue', 'content' => 'Bonjour, monde !'];

        //Appelle la méthode render
        $result = $renderer->render($data, 'test.twig');

        //Vérifie le contenu retourné
        $this->assertStringContainsString('<h1>Bienvenue</h1>', $result);
        $this->assertStringContainsString('<p>Bonjour, monde !</p>', $result);

        //Nettoyage après le test : Supprimer le fichier template et le dossier
        unlink($templateFile); // Supprime le fichier template
        rmdir($templatePath);  // Supprime le dossier de test (si vide)
    }

    public function testRegister()
    {
        //Chemin pour les templates
        $templatePath = __DIR__ . DIRECTORY_SEPARATOR . 'templates';  // Chemin absolu

        //Crée le dossier principal pour les templates s'il n'existe pas
        if (!is_dir($templatePath)) {
            mkdir($templatePath);
        }

        //Crée un sous-dossier "admin"
        $adminPath = $templatePath . '\\admin'; 
        if (!is_dir($adminPath)) {
            mkdir($adminPath); // Crée le sous-dossier "admin" 
        }

        //Crée un fichier template "dashboard.twig" dans le sous-dossier "admin"
        $templateFile = $adminPath . '\\dashboard.twig'; 
        file_put_contents($templateFile, '<h1>{{ title }}</h1>');

        //Initialise TwigRenderer avec le chemin des templates
        $renderer = new TwigRenderer($templatePath);

        //Enregistre l'alias 'admin' pour le sous-dossier "admin" avec addPath()
        $renderer->getTwig()->getLoader()->addPath($adminPath, 'admin');

        //Rendu du template avec les données
        $output = $renderer->render(['title' => 'Dashboard Admin'], 'admin/dashboard.twig');

        //Vérifie si le rendu du template contient le texte attendu
        $this->assertStringContainsString('<h1>Dashboard Admin</h1>', $output);

        // Nettoyage après le test
        unlink($templateFile); // Supprime le fichier template
        rmdir($adminPath);     // Supprime le sous-dossier "admin"
        rmdir($templatePath);  // Supprime le dossier principal "templates"
    }

    //Supprime un dossier et tout son contenu
    private function deleteDirectory(string $dir): void
    {
        // Si ce n'est pas un dossier, on arrête la fonction
        if (!is_dir($dir)) {
            return;
        }

        // On parcourt tous les fichiers et sous-dossiers dans le dossier
        foreach (scandir($dir) as $item) {
            // On ignore les dossiers spéciaux "." et ".."
            if ($item === '.' || $item === '..') {
                continue;
            }

            // On construit le chemin complet de chaque fichier ou dossier
            $path = $dir . DIRECTORY_SEPARATOR . $item;

            // Si c'est un sous-dossier, on l'efface d'abord
            if (is_dir($path)) {
                $this->deleteDirectory($path); // Suppression du sous-dossier
            } else {
                // Si c'est un fichier, on le supprime
                unlink($path); // Supprime le fichier
            }
        }

        // Après avoir supprimé tout, on supprime le dossier vide
        rmdir($dir); // Supprime le dossier vide
    }
}