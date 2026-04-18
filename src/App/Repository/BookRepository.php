<?php

namespace App\Repository;

use Framework\Database\ConnectionInterface;
use Framework\Database\DataMapper;
use Framework\Database\RepositoryInterface;

// geen blokhaakjes gebruiken tot nu toe niks goeds van gekomen :(
class BookRepository implements RepositoryInterface
{

    private DataMapper $dataMapper;
    public function __construct(DataMapper $dataMapper) {
        $this->dataMapper = $dataMapper;
    }
    public function getAll(): array
    {
        return $this->dataMapper->select("SELECT * FROM books");
    }

    public function get(int $id): object
    {
        return $this->dataMapper->get($id);
    }

    public function update(object  $object): void
    {
        $this->dataMapper->update($object);
    }

    public function save(object  $object): void
    {
        $this->dataMapper->insert($object);
    }

    public function remove($object): void
    {
        $this->dataMapper->delete($object);
    }

    public function findGenre(mixed $genre): array
    {
        $sql = "SELECT * FROM books b 
            JOIN genres g ON b.genre_id = g.id 
            WHERE g.name = ?";

        return $this->dataMapper->select($sql, $genre);
    }

    public function getGenre(mixed $id): array
    {
        $sql = "SELECT books.*, genres.name as genre_name 
            FROM books 
            JOIN genres ON books.genre_id = genres.id 
            WHERE books.id = ?";

        return $this->dataMapper->select($sql, $id);
    }
}