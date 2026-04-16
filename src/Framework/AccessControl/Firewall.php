<?php

namespace Framework\AccessControl;

use Framework\AccessControl\FirewallInterface;
use Framework\AccessControl\UserInterface;
use Framework\Http\RequestInterface;

class Firewall implements FirewallInterface
{
    private AuthorizationService $authorizationService;
    public function __construct(AuthorizationService $authorizationService){
        $this->authorizationService = $authorizationService;
    }

    public function accepts(RequestInterface $request, UserInterface $user): bool
    {
        $path = $request->getUri()->getPath();

        if (str_starts_with($path, '/admin')) {
            return $this->authorizationService->isGranted($user, 'admin');
        }
        return true;
    }
}