<?php

namespace App\Repository;

use Framework\Database\ConnectionInterface;
use Framework\Database\RepositoryInterface;

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

    public function save(object $book): void
    {
        $this->connection->query(
            "INSERT INTO books (title, author, description, genre) VALUES (?, ?, ?, ?)",
            [
                $book->title,
                $book->author,
                $book->description,
                $book->genre_id
            ]
        );
    }

    public function remove($object): void
    {
        if (isset($object->id)) {
            $this->connection->query("DELETE FROM books WHERE id = ?", [$object->id]);
        }
    }

    public function findGenre(mixed $genre): array
    {
        $sql = "SELECT * FROM books b 
            JOIN genres g ON b.genre_id = g.id 
            WHERE g.name = ?";

        return $this->connection->query($sql, $genre);
    }
}