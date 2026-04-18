<?php

namespace App\Repository;

use Framework\Database\ConnectionInterface;
use Framework\Database\RepositoryInterface;

// geen blokhaakjes gebruiken tot nu toe niks goeds van gekomen :(
class BookRepository implements RepositoryInterface
{
    public function __construct(private ConnectionInterface $connection) {}
    public function getAll(): array
    {
        return $this->connection->query("SELECT * FROM books");
    }

    public function get(int $id): object
    {
        $rows = $this->connection->query("SELECT * FROM books WHERE id = ?", $id);

        if (empty($rows)) {
            return new \stdClass();
        }

        return (object) $rows[0];
    }

    public function update(object $book): void
    {
        $this->connection->execute(
            "UPDATE books SET title = ?, author = ?, description = ?, genre_id = ? WHERE id = ?",
            $book->title,
            $book->author,
            $book->description,
            $book->genre_id,
            $book->id
        );
    }

    public function save(object $book): void
    {
        $this->connection->query(
            "INSERT INTO books (title, author, description, genre_id) VALUES (?, ?, ?, ?)",
            $book->title,
            $book->author,
            $book->description,
            $book->genre_id
        );
    }

    public function remove($object): void
    {
        if (isset($object->id)) {
            $this->connection->query("DELETE FROM books WHERE id = ?", $object->id);
        }
    }

    public function findGenre(mixed $genre): array
    {
        $sql = "SELECT * FROM books b 
            JOIN genres g ON b.genre_id = g.id 
            WHERE g.name = ?";

        return $this->connection->query($sql, $genre);
    }

    public function getGenre(mixed $id): array
    {
        $sql = "SELECT books.*, genres.name as genre_name 
            FROM books 
            JOIN genres ON books.genre_id = genres.id 
            WHERE books.id = ?";

        return $this->connection->query($sql, $id);
    }

    public function getAllGenreNames(): array
    {
        $sql = "SELECT * FROM genres ORDER BY name";
        return $this->connection->query($sql);
    }

    public function addReview(int $bookId, int $userId, int $score, string $text): void
    {
        $this->connection->query(
            "INSERT INTO reviews (book_id, user_id, score, text) VALUES (?, ?, ?, ?)",
            $bookId,
            $userId,
            $score,
            $text
        );
    }

    public function getReviewsByBook(int $bookId): array
    {
        $sql = "SELECT r.*, u.username FROM reviews r 
            JOIN users u ON r.user_id = u.id 
            WHERE r.book_id = ?";

        return $this->connection->query($sql, $bookId);
    }
}