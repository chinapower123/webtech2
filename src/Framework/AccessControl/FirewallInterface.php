<?php

namespace Framework\AccessControl;

use Framework\Http\RequestInterface;

/**
 * A service that can block unauthorized users from accessing parts of the website.
 */
interface FirewallInterface
{
    /**
     * Checks whether the user is allowed to perform the request.
     * @param RequestInterface $request
     * @param UserInterface $user
     * @return bool
     */
    function accepts(RequestInterface $request, UserInterface $user): bool;
}