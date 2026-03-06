<?php
namespace App;

use Symfony\Component\HttpFoundation\Response;

class HomeController {
    public function hello($name) {
        // Criando o objeto Response conforme o material 
        $content = sprintf('Hello %s', htmlspecialchars($name, ENT_QUOTES, 'UTF-8'));
        return new Response($content);
    }
}