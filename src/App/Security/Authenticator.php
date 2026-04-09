<?php

namespace App\Security;

use Framework\AccessControl\AuthenticationInterface;
use Framework\AccessControl\UserInterface;
use Framework\AccessControl\UserProviderInterface;
use Framework\Http\RequestInterface;
use Framework\Http\SessionInterface;
use App\Entity\User;

class Authenticator implements AuthenticationInterface
{
    private UserProviderInterface $userProvider;
    private SessionInterface $session;

    public function __construct(UserProviderInterface $userProvider, SessionInterface $session) {
        $this->userProvider = $userProvider;
        $this->session = $session;
    }

    public function authenticate(RequestInterface $request): UserInterface {
        $username = $request->getPostData('username');
        $password = $request->getPostData('password');

        if ($username && $password) {
            $user = $this->userProvider->get($username);
            if (!$user->isAnonymous() && password_verify($password, $user->getPasswordHash())) {
                $this->session['user'] = $user->getUsername();
                return $user;
            }
        }

        if (isset($this->session['user'])) {
            return $this->userProvider->get($this->session['user']);
        }

        return new User();
    }
}
