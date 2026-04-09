<?php

namespace App\Repository;

use App\Entity\User;
use Framework\AccessControl\UserInterface;
use Framework\AccessControl\UserProviderInterface;
use Framework\Database\ConnectionInterface;

class UserRepository implements UserProviderInterface
{
    private ConnectionInterface $connection; // Gebruik connection ipv pdo

    public function __construct(ConnectionInterface $connection) {
        $this->connection = $connection;
    }

    public function get(string $username): UserInterface {
        $rows = $this->connection->query("SELECT * FROM users WHERE username = ?", $username);

        if (count($rows) > 0) {
            $data = $rows[0];
            return new User($data['username'], $data['password'], false);
        }

        return new User('', '', true); // Anoniem
    }
}