<?php

namespace Framework\Database;

use Framework\Database\IdentityMapInterface;

/**
 * @template T
 */
class IdentityMap implements IdentityMapInterface
{
    private array $objects = [];
    function has(int $id): bool
    {
        return isset($this->objects[$id]);
    }

    function contains($object): bool
    {
        return in_array($object, $this->objects, true);
    }

    function get(int $id): object
    {
        if($this->has($id)){
            return $this->objects[$id];
        }else{
            throw new \Exception("Object $id does not exist");
        }
    }

    function add(int $id, $object): void
    {
        $this->objects[$id] = $object;
    }

    function remove($object): void
    {
        $key = array_search($object, $this->objects, true);

        if($key !== false){
            unset($this->objects[$key]);
        }
    }
}
