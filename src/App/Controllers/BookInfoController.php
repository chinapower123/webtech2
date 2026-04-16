<?php
namespace App\Controllers;

use App\Repository\BookRepository;
use Framework\Http\RequestInterface;
use Framework\Templating\TemplateEngine;

class BookInfoController
{
    public function __construct(
        private TemplateEngine $templateEngine,
        private BookRepository $bookRepository
    ) {}

    public function index(RequestInterface $request): string
    {
        $user = $request->getAttribute('user');

        $id = (int)($request->getQueryParams()['id'] ?? 0);

        $book = $this->bookRepository->get($id);

        return $this->templateEngine->render('BookInfo.html', [
            'id'   => $id,
            'book' => $book,
            'user' => $user
        ]);
    }
}