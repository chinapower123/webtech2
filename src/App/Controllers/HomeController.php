<?php
namespace App\Controllers;

use App\Repository\BookRepository;
use Framework\Http\RequestInterface;
use Framework\Templating\TemplateEngine;

class HomeController
{
    private BookRepository $bookRepository;
    private TemplateEngine $templateEngine;

    public function __construct(TemplateEngine $templateEngine, BookRepository $bookRepository) {
        $this->templateEngine = $templateEngine;
        $this->bookRepository = $bookRepository;
    }

    public function home(RequestInterface $request): string
    {
        $user = $request->getAttribute('user');
        $books = $this->bookRepository->getAll();

        return $this->templateEngine->render('Home.html', [
            'books' => $books,
            'user'  => $user
        ]);
    }
}