<?php

namespace App\Entity;

use Framework\AccessControl\UserInterface;

class User implements UserInterface
{
    private string $username;
    private string $passwordHash;
    private bool $isAnonymous;

    public function __construct(string $username = 'anonymous', string $passwordHash = '', bool $isAnonymous = true) {
        $this->username = $username;
        $this->passwordHash = $passwordHash;
        $this->isAnonymous = $isAnonymous;
    }

    public function getUsername(): string { return $this->username; }
    public function getPasswordHash(): string { return $this->passwordHash; }
    public function isAnonymous(): bool { return $this->isAnonymous; }
}