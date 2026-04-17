<?php
namespace App\Controllers;

use App\Repository\BookRepository;
use Framework\HTTP\RequestInterface;
use Framework\Templating\TemplateEngine;

class BookEditController
{
    public function __construct(
        private TemplateEngine $templateEngine,
        private BookRepository $bookRepository
    ) {}

    public function edit(RequestInterface $request): string
    {
        $id = $request->getQueryParams()['id'] ?? null;
        $rows = $this->bookRepository->getGenre($id);
        $book = (object) $rows[0];
        $genres = $this->bookRepository->getAllGenreNames();


        return $this->templateEngine->render('boek-bewerken.html', [
            'book' => $book,
            'genres' => $genres
        ]);
    }

    public function update(RequestInterface $request): string
    {
        $data = $request->getParsedBody();
        $book = (object) [
            'id'          => $data['id'],
            'title'       => $data['title'],
            'author'      => $data['author'],
            'description' => $data['description'],
            'genre_id'       => $data['genre_id'],
        ];
        $this->bookRepository->update($book);
        header('Location: /boeken');
        exit();
    }
}