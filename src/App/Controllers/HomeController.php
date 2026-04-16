<?php
namespace App\Controllers;

use Framework\Http\RequestInterface;
use Framework\Templating\TemplateEngine;

class HomeController
{
    public function __construct(private TemplateEngine $templateEngine) {}

    public function index(RequestInterface $request): string
    {
        $user = $request->getAttribute('user');

        return $this->templateEngine->render('Home.html', [
            'user' => $user
        ]);
    }
}