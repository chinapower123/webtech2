<?php
namespace App\Controllers;
use App\Entity\Genre;
use App\Repository\GenreRepository;
use Framework\HTTP\RequestInterface;
use Framework\Templating\TemplateEngine;

class GenreController
{
    private TemplateEngine $templateEngine;
    private GenreRepository $genreRepository;

    public function __construct(TemplateEngine $templateEngine, GenreRepository $genreRepository){
        $this->templateEngine = $templateEngine;
        $this->genreRepository = $genreRepository;
    }

    public function index(RequestInterface $request): string
    {
        $user = $request->getAttribute('user');
        $genres = $this->genreRepository->getAllGenreNames();
        return $this->templateEngine->render('genre-beheer.html', [
            'genres' => $genres,
            'user' => $user
        ]);
    }

    public function delete(RequestInterface $request): void
    {
        $genreId = $this->genreRepository->get((int)$request->getQueryParams()['id'] ?? null);
        $this->genreRepository->remove($genreId);

        header('Location: /genre-beheer');
        exit();
    }
    public function create(RequestInterface $request): string
    {
        $user = $request->getAttribute('user');

        return $this->templateEngine->render('genre-toevoegen.html', [
            'user' => $user
        ]);
    }

    public function store(RequestInterface $request)
    {
        $data = $request->getParsedBody();
        $genre = new Genre();

        $genre->id = $data['id'];
        $genre->name = $data['name'];

        $this->genreRepository->save($genre);

        header('Location: /genre-beheer');
        exit();
    }
}