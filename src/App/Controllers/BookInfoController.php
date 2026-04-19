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
        $bookId = (int)($request->getQueryParams()['id'] ?? 0);

        $deleteId = $request->getQueryParams()['delete_review'] ?? null;
        if ($deleteId && $user && !$user->isAnonymous()) {
            $review = $this->reviewRepository->getById((int)$deleteId);

            if ($review && ($review->user_id == $user->getId() || in_array('admin', $user->getRoles()))) {
                $this->reviewRepository->remove($review);
                header("Location: /boek-info?id=$bookId");
                exit;
            }
        }
        if ($request->getMethod() === 'POST' && $user && !$user->isAnonymous()) {
            $score = (int)$request->getPostData('score');
            $text = $request->getPostData('review_text');
            $reviewId = $request->getPostData('review_id');
            $userId = $user->getId();

            if ($reviewId) {
                $existingReview = $this->reviewRepository->getById((int)$reviewId);
                if ($existingReview && $existingReview->user_id == $userId) {
                    $this->reviewRepository->updateReview((int)$reviewId, $score, $text);
                }
            } else {
                $this->reviewRepository->addReview($bookId, (int)$userId, $score, $text);
            }

            header("Location: /boek-info?id=$bookId");
            exit;
        }

        $rows = $this->bookRepository->getGenre($bookId);
        $book = !empty($rows) ? (object) $rows[0] : new \stdClass();
        $reviews = $this->reviewRepository->getReviewsByBook($bookId);

        return $this->templateEngine->render('BookInfo.html', [
            'id'      => $bookId,
            'book'    => $book,
            'user'    => $user,
            'reviews' => $reviews
        ]);
    }
}