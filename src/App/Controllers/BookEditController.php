<?php
namespace App\Controllers;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\GenreRepository;
use Framework\HTTP\RequestInterface;
use Framework\Templating\TemplateEngine;

class BookEditController
{
    public function __construct(
        private TemplateEngine $templateEngine,
        private BookRepository $bookRepository,
        private GenreRepository $genreRepository,
    ) {}

    public function create(RequestInterface $request): string
    {
        $user = $request->getAttribute('user');

        return $this->templateEngine->render('boek-toevoegen.html',[
            'genres' => $this->genreRepository->getAllGenreNames(),
            'isNew' => true,
            'user' => $user
        ]);
    }

    public function store(RequestInterface $request): void
    {
        $data = $request->getParsedBody();
        $book = new Book();

        $book->id = $data['id'];
        $book->title = $data['title'];
        $book->author = $data['author'];
        $book->description = $data['description'];
        $book->genre_id = $data['genre_id'];

        $this->bookRepository->save($book);

        header('Location: /boeken');
        exit();
    }

    public function edit(RequestInterface $request): string
    {
        $user = $request->getAttribute('user');
        $id = $request->getQueryParams()['id'] ?? null;
        $rows = $this->bookRepository->getGenre($id);
        $book = (object) $rows[0];
        $genres = $this->genreRepository->getAllGenreNames();


        return $this->templateEngine->render('boek-bewerken.html', [
            'book' => $book,
            'genres' => $genres,
            'user' => $user
        ]);
    }

    public function delete(RequestInterface $request)
    {
        $id = (int)$request->getQueryParams()['id'] ?? null;
        $book = $this->bookRepository->get($id);
        $this->bookRepository->remove($book);
        header('Location: /boeken');
        exit();
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