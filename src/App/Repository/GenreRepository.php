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

    function save(object $object): void
    {
        if($object->getId() !== null){
            $this->dataMapper->insert($object);
        } else{
            $this->dataMapper->update($object);
        }
    }

    function remove($object): void
    {
        $this->dataMapper->delete($object);
    }
}