<?php

namespace App\Repository;

use Framework\Database\DataMapper;
use Framework\Database\RepositoryInterface;

class BookRepository implements RepositoryInterface
{
    private DataMapper $dataMapper;

    public function __construct(DataMapper $dataMapper) {
        $this->dataMapper = $dataMapper;
    }

    public function getAll(): array
    {
        $sql = "SELECT b.*, AVG(r.score) as average_score 
                FROM books b 
                LEFT JOIN reviews r ON b.id = r.book_id 
                GROUP BY b.id";
        return $this->dataMapper->select($sql);
    }

    public function get(int $id): object
    {
        return $this->dataMapper->get($id);
    }

    public function update(object $object): void
    {
        $this->dataMapper->update($object);
    }

    public function save(object $object): void
    {
        $this->dataMapper->insert($object);
    }

    public function remove($object): void
    {
        $this->dataMapper->delete($object);
    }

    public function findGenre(mixed $genre): array
    {
        $sql = "SELECT b.*, AVG(r.score) as average_score FROM books b 
            LEFT JOIN genres g ON b.genre_id = g.id 
            LEFT JOIN reviews r ON b.id = r.book_id
            WHERE g.name = ?
            GROUP BY b.id";

        return $this->dataMapper->select($sql, $genre);
    }

    public function getGenre(mixed $id): array
    {
        $sql = "SELECT books.*, genres.name as genre_name, AVG(reviews.score) as average_score 
            FROM books 
            LEFT JOIN genres ON books.genre_id = genres.id 
            LEFT JOIN reviews ON books.id = reviews.book_id
            WHERE books.id = ?
            GROUP BY books.id";

        return $this->dataMapper->select($sql, $id);
    }

    public function addReview(int $bookId, int $userId, int $score, string $text): void
    {
        $sql = "INSERT INTO reviews (book_id, user_id, score, text) VALUES (?, ?, ?, ?)";
        $this->dataMapper->select($sql, $bookId, $userId, $score, $text);
    }

    public function getReviewsByBook(int $bookId): array
    {
        $sql = "SELECT r.*, u.username FROM reviews r 
                JOIN users u ON r.user_id = u.id 
                WHERE r.book_id = ?
                ORDER BY r.id DESC";
        return $this->dataMapper->select($sql, $bookId);
    }

    public function search(string $query): array
    {
        $sql = "SELECT b.*, AVG(r.score) as average_score 
            FROM books b 
            LEFT JOIN reviews r ON b.id = r.book_id 
            WHERE b.title LIKE ? OR b.author LIKE ?
            GROUP BY b.id";

        $searchTerm = "%$query%";

        return $this->dataMapper->select($sql, $searchTerm, $searchTerm);
    }

    public function getAllGenres(): array
    {
        return $this->dataMapper->select("SELECT * FROM genres ORDER BY name ASC");
    }
}