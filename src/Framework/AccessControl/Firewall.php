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
        $protectedPaths = [
            'admin',
            'boek-toevoegen',
            'boek-toevoegen-verwerken',
            'boek-bewerken-verwerken',
            'genre-toevoegen-verwerken',
            'genre-toevoegen',
            'boek-bewerken',
            'genre-verwijderen',
            'boek-verwijderen',
            'genre-beheer',
            'review-verwijderen'
        ];
        foreach ($protectedPaths as $protectedPath) {
            if (str_starts_with($path, '/' . $protectedPath)) {
                return $this->authorizationService->isGranted($user, 'admin');
            }
        }
        return true;
    }
}