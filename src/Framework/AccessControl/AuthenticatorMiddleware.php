<?php

namespace Framework\AccessControl;

use Framework\Http\RequestInterface;
use Framework\Http\ResponseInterface;
use Framework\Kernel\MiddlewareInterface;
use Framework\Kernel\RequestHandlerInterface;

class AuthenticatorMiddleware implements MiddlewareInterface
{
    private AuthenticationInterface $authenticator;

    public function __construct(AuthenticationInterface $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    public function process(RequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $user = $this->authenticator->authenticate($request);
        $request = $request->withAttribute('user', $user);
        return $handler->handle($request);
    }
}