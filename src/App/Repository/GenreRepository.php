<?php

namespace App\Repository;

use Framework\Database\DataMapper;
use Framework\Database\RepositoryInterface;

class GenreRepository implements RepositoryInterface{

    private DataMapper $dataMapper;
    public function __construct(DataMapper $dataMapper){
        $this->dataMapper = $dataMapper;
    }
    function get(int $id): object
    {
        return $this->dataMapper->get($id);
    }

    public function update(object $object): void
    {
        $this->dataMapper->update($object);
    }

    function save(object $object): void
    {
        $this->dataMapper->insert($object);
    }

    function remove($object): void
    {
        $this->dataMapper->delete($object);
    }

    public function getAllGenreNames(): array
    {
        $sql = "SELECT * FROM genres ORDER BY id";
        return $this->dataMapper->select($sql);
    }

}