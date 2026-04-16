<?php
namespace App\Controllers;

use App\Repository\BookRepository;
use Framework\Templating\TemplateEngine;

class BookController
{
    public function __construct(
        private TemplateEngine $templateEngine,
        private BookRepository $bookRepository
    ) {}

    public function index($request): string
    {
        $user = $request->getAttribute('user');

        $books = $this->bookRepository->getAll();

        return $this->templateEngine->render('Boeken.html', [
            'books' => $books,
            'user'  => $user
        ]);
    }
}