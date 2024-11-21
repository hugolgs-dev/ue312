<?php

namespace Framework312\Template;

class TestRenderer implements Renderer {
    public function render(mixed $data, string $template): string {
        return "Rendered: $template with data: " . json_encode($data);
    }

    public function register(string $tag) {
        // Méthode vide pour les tests
    }
}
