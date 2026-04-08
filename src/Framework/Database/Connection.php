<?php
namespace Framework\Database;
use PDO;
class Connection implements ConnectionInterface {
    private PDO $pdo;
    public function __construct(string $file) {
        if(!file_exists($file)){
            throw new \Exception("Bestand bestaat niet");
        }else{
            $this->pdo = new PDO("sqlite:$file");
        }

    }
    function query(string $query, ...$params): array
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    function execute(string $query, ...$params): int
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    function getLastInsertId(): int
    {
        return $this->pdo->lastInsertId();
    }
}