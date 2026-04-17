<?php
namespace App\Controllers;
use Framework\HTTP\RequestInterface;
use Framework\Templating\TemplateEngine;

class AdminController
{
    private TemplateEngine $templateEngine;

    public function __construct(TemplateEngine $templateEngine){
        $this->templateEngine = $templateEngine;
    }
    public function index(RequestInterface $request): string
    {
        $user = $request->getAttribute('user');

        return $this->templateEngine->render('Admin.html', [
            'user' => $user
        ]);

    }
}