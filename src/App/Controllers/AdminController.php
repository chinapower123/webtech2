<?php
namespace App\Controllers;
use App\Entity\Book;
use App\Repository\BookRepository;
use Framework\HTTP\RequestInterface;
use Framework\Templating\TemplateEngine;

class AdminController
{
    private TemplateEngine $templateEngine;
    private BookRepository $bookRepository;

    public function __construct(TemplateEngine $templateEngine, BookRepository $bookRepository){
        $this->templateEngine = $templateEngine;
        $this->bookRepository = $bookRepository;
    }
    public function index(RequestInterface $request): string
    {
        $user = $request->getAttribute('user');
        $books = $this->bookRepository->getAll();


        return $this->templateEngine->render('Admin.html', [
            'user' => $user,
            'books' => $books
        ]);

    }
}