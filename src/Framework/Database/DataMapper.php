<?php

namespace Framework\Database;

use Framework\Database\DataMapperInterface;
use Framework\Exceptions\NotFoundException;
use PDO;
use Psr\Container\NotFoundExceptionInterface;

/**
 * A service that maps domain objects to database records.
 * @template T
 */
class DataMapper implements DataMapperInterface{

    private IdentityMap $identityMap;
    private string $tableName;
    private Connection $connection;
    private string $class;

    public function __construct(IdentityMap $identityMap, Connection $connection, string $tableName, string $class)
    {
        $this->identityMap = $identityMap;
        $this->connection = $connection;
        $this->tableName = $tableName;
        $this->class = $class;
    }

    function get(int $id): object
    {
        if ($this->identityMap->has($id)) {
            return $this->identityMap->get($id);
        }else{
            $result = $this->select("SELECT * FROM {$this->tableName} WHERE id = ?", $id);
        }
        if(empty($result)){
            throw new NotFoundException("Object with $id does not exist");
        }

        $object = $result[0];
        $this->identityMap->add($id, $object);
        return $object;
    }

    function select(string $query, ...$params): array
    {
        $rows = $this->connection->query($query, ...$params);

        $results = [];
        foreach ($rows as $row) {
            $object = new $this->class();
            foreach ($row as $column => $value) {
                $object->$column = $value;
            }
            $results[] = $object;
        }
        return $results;
    }

    function insert($object): void
    {
        $data = (array) $object;
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $this->connection->execute(
            "INSERT INTO {$this->tableName} ($columns) VALUES ($placeholders)",
            ...array_values($data)
        );

        $id = $this->connection->getLastInsertId();
        $object->id = $id;
        $this->identityMap->add($id, $object);
    }

    function update($object): void
    {
        $data = (array) $object;
        $id = $data['id'];
        unset($data['id']);

        $sets = implode(', ', array_map(fn($col) => "$col = ?", array_keys($data)));
        $values = array_values($data);
        $values[] = $id;

        $this->connection->execute(
            "UPDATE {$this->tableName} SET $sets WHERE id = ?",
            ...$values,

        );
    }

    function delete($object): void
    {
        $data = (array) $object;

        $this->connection->execute(
            "DELETE FROM {$this->tableName} WHERE id = ?",
            $data['id']
        );

        $this->identityMap->remove($object);
    }
}
