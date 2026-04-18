<?php
namespace App\Controllers;

use App\Repository\BookRepository;
use App\Repository\ReviewRepository;
use Framework\Http\RequestInterface;
use Framework\Templating\TemplateEngine;

class BookInfoController
{
    public function __construct(
        private TemplateEngine $templateEngine,
        private BookRepository $bookRepository,
        private ReviewRepository $reviewRepository,
    ) {}

    public function index(RequestInterface $request): string
    {
        $user = $request->getAttribute('user');
        $id = (int)($request->getQueryParams()['id'] ?? 0);

        if ($request->getMethod() === 'POST' && $user && !$user->isAnonymous()) {
            $score = (int)$request->getPostData('score');
            $text = $request->getPostData('review_text');

            $userId = null;
            if (method_exists($user, 'getId')) {
                $userId = $user->getId();
            } elseif (isset($user->id)) {
                $userId = $user->id;
            }

            if (!$userId && method_exists($user, 'getAttributes')) {
                $userId = $user->getAttributes()['id'] ?? null;
            }

            $this->reviewRepository->addReview($id, (int)$userId, $score, $text);

            header("Location: /boek-info?id=$id");
            exit;
        }

        $rows = $this->bookRepository->getGenre($id);

        $book = !empty($rows) ? (object) $rows[0] : new \stdClass();

        $reviews = $this->reviewRepository->getReviewsByBook($id);

        return $this->templateEngine->render('BookInfo.html', [
            'id'      => $id,
            'book'    => $book,
            'user'    => $user,
            'reviews' => $reviews
        ]);
    }
}