<?php

namespace App\Controllers;

use App\Repository\ReviewRepository;
use Framework\HTTP\RequestInterface;

class ReviewController{
    private ReviewRepository $reviewRepository;
    public function __construct(ReviewRepository $reviewRepository){
        $this->reviewRepository = $reviewRepository;
    }

    public function delete(RequestInterface $request)
    {

        $user = $request->getAttribute('user');
        if (!$user || !in_array('admin', $user->getRoles())) {
            die("Niet toegestaan");
        }

        $id = (int)$request->getQueryParams()['id'];
        $bookId = (int)$request->getQueryParams()['book_id'];

        $review = $this->reviewRepository->get($id);
        $this->reviewRepository->remove($review);

        header("Location: /boek-info?id=" . $bookId);
        exit();
    }


}