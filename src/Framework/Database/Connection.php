<?php
namespace Framework\Database;
use PDO;

class Connection implements ConnectionInterface {
    private PDO $pdo;

    public function __construct(string $file) {
        if(!file_exists($file)){
            throw new \Exception("Bestand bestaat niet");
        } else {
            $this->pdo = new PDO("sqlite:$file", null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

            $this->pdo->exec('PRAGMA foreign_keys = ON;');
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
        return (int)$this->pdo->lastInsertId();
    }
}