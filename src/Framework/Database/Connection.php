<?php
namespace Framework\Database;
use PDO;
class Connection implements ConnectionInterface {
    private PDO $connection;
    public function __construct(string $file) {
        $file = realpath($file);
        if(!$file) {
            throw new \Exception('File not found');
        }
        $this->connection = new \PDO("sqlite:$file");
    }
    public function query(string $query, ...$params): array
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function execute(string $query, ...$params): int
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public function getLastInsertId(): int
    {
        return (int) $this->connection->lastInsertId();
    }
}