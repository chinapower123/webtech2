<?php

namespace App\Repository;

use Framework\Database\ConnectionInterface; // Gebruik de connectie direct
use Framework\Database\RepositoryInterface;

class BookRepository implements RepositoryInterface
{
    public function __construct(private ConnectionInterface $connection) {}

    public function getAll(): array
    {
        // Haalt alle boeken op als arrays uit de database
        return $this->connection->query("SELECT * FROM books");
    }

    public function get(int $id): object
    {
        $rows = $this->connection->query("SELECT * FROM books WHERE id = ?", $id);

        if (count($rows) === 0) {
            // Als er niets gevonden is, geven we een leeg object terug
            // om te voldoen aan de 'object' return type
            return new \stdClass();
        }

        // We zetten de array om naar een object (stdClass)
        return (object) $rows[0];
    }

    // De rest van de methodes (save/remove) kun je laten staan of later invullen
    public function save(object $object): void {}
    public function remove($object): void {}
}