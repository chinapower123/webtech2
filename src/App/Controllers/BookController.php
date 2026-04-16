<?php
namespace App\Controllers;

use App\Repository\BookRepository;
use Framework\HTTP\RequestInterface;
use Framework\Templating\TemplateEngine;

class BookController
{
    public function __construct(
        private TemplateEngine $templateEngine,
        private BookRepository $bookRepository
    ) {}

    public function index(RequestInterface $request): string
    {
        $user = $request->getAttribute('user');
        $genre = $request->getQueryParams()['genre'] ?? null;

        if($genre){
            $genre = ucfirst($genre);
            $books = $this->bookRepository->findGenre($genre);
        }else{
            $books = $this->bookRepository->getAll();
        }

        return $this->templateEngine->render('Boeken.html', [
            'books' => $books,
            'user'  => $user
        ]);
    }
}