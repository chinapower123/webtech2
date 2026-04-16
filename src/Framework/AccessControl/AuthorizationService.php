<?php

namespace Framework\AccessControl;

use Exception;

class AuthorizationService implements AuthorizationInterface
{
    public function isGranted(UserInterface $user, string $permission, ...$parameters): bool
    {
        if ($user->isAnonymous()) {
            return false;
        }

        return in_array($permission, $user->getRoles());
    }

    public function denyUnlessGranted(UserInterface $user, string $permission, ...$parameters): void
    {
        if (!$this->isGranted($user, $permission, ...$parameters)) {
            throw new Exception("Toegang Geweigerd.");
        }
    }
}