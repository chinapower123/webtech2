<?php

namespace Framework\AccessControl;

use Framework\Http\RequestInterface;

/**
 * A service that can authenticate a user based on information in the current request.
 */
interface AuthenticationInterface
{

    /**
     * Authenticate the given request.
     * @param RequestInterface $request
     * @return UserInterface The user that was found in the request, or an anonymous user if no user was found.
     */
    function authenticate(RequestInterface $request): UserInterface;
}