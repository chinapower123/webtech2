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
            $roles = isset($data['role']) ? [$data['role']] : ['user'];

            return new User(
                (int)$data['id'],
                $data['username'],
                $data['password'],
                $roles,
                false
            );
        }
        return new User(null, '', '', [], true);
    }

    public function create(string $username, string $password): void
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $this->connection->query(
            "INSERT INTO users (username, password) VALUES (?, ?)",
            $username,
            $hashedPassword
        );
    }
}