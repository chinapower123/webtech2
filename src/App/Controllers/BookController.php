<?php
namespace App\Controllers;
use Framework\Templating\TemplateEngine;

class BookController
{
    private TemplateEngine $templateEngine;

    public function __construct(TemplateEngine $templateEngine){
        $this->templateEngine = $templateEngine;
    }
    public function index():string
    {
        return $this->templateEngine->render('boeken.html');
    }
}