<?php
namespace App\Controllers;
use Framework\Templating\TemplateEngine;
use Symfony\Bridge\Twig\Validator\Constraints\Twig;

class RegisterController
{
    private TemplateEngine $templateEngine;

    public function __construct(TemplateEngine $templateEngine){
        $this->templateEngine = $templateEngine;
    }
    public function index():string
    {
        return $this->templateEngine->render('Registration.html');
    }
}