<?php


namespace App\Repository;

use App\Entity\Review;
use Framework\Database\DataMapper;
use Framework\Database\RepositoryInterface;

class ReviewRepository implements RepositoryInterface
{
    private DataMapper $dataMapper;

    public function __construct(DataMapper $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }

    function get(int $id): object
    {
        return $this->dataMapper->get($id);
    }

    function save(object $object): void
    {
        if (isset($object->id)) {
            $this->dataMapper->update($object);
        } else {
            $this->dataMapper->insert($object);
        }
    }

    function remove($object): void
    {
        $this->dataMapper->delete($object);
    }

    public function addReview(int $bookId, int $userId, int $score, string $text): void
    {
        $review = new Review();
        $review->book_id = $bookId;
        $review->user_id = $userId;
        $review->score = $score;
        $review->text = $text;
        $this->dataMapper->insert($review);
    }

    public function getReviewsByBook(int $bookId): array
    {
        $sql = "SELECT r.*, u.username FROM reviews r 
            JOIN users u ON r.user_id = u.id 
            WHERE r.book_id = ?";

        return $this->dataMapper->select($sql, $bookId);
    }

    public function getById(int $id): ?object
    {
        $result = $this->dataMapper->select("SELECT * FROM reviews WHERE id = ?", $id);
        return !empty($result) ? $result[0] : null;
    }

    public function updateReview(int $id, int $score, string $text): void
    {
        $sql = "UPDATE reviews SET score = ?, text = ? WHERE id = ?";
        $this->dataMapper->select($sql, $score, $text, $id);
    }
}