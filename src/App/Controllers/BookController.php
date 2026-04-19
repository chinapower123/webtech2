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
        $query = $request->getQueryParams()['q'] ?? null;

        if ($query) {
            $books = $this->bookRepository->search($query);
        } elseif ($genre) {
            $books = $this->bookRepository->findGenre(ucfirst($genre));
        } else {
            $books = $this->bookRepository->getAll();
        }

        $allGenres = $this->bookRepository->getAllGenres();

        return $this->templateEngine->render('Boeken.html', [
            'books'      => $books,
            'user'       => $user,
            'allGenres'  => $allGenres,
            'activeGenre'=> $genre,
            'searchTerm' => $query
        ]);
    }
}