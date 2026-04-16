<?php

namespace App\Entity;

use Framework\AccessControl\UserInterface;

class User implements UserInterface
{
    private string $username;
    private string $passwordHash;
    private bool $isAnonymous;
    private array $roles;

    public function __construct(string $username = 'anonymous', string $passwordHash = '', array $roles = [],  bool $isAnonymous = true) {
        $this->username = $username;
        $this->passwordHash = $passwordHash;
        $this->isAnonymous = $isAnonymous;
        $this->roles = $roles;
    }

    public function getUsername(): string { return $this->username; }
    public function getPasswordHash(): string { return $this->passwordHash; }
    public function isAnonymous(): bool { return $this->isAnonymous; }

    function getRoles(): array
    {
        return $this->roles;
    }
}