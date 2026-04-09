<?php

namespace Framework\Kernel;

use Framework\AccessControl\AuthenticationInterface;
use Framework\Http\RequestInterface;
use Framework\Http\Response;
use Framework\Http\ResponseInterface;
use Framework\Routing\RouterInterface;

class Kernel implements KernelInterface
{
    private RouterInterface $router;
    private AuthenticationInterface $authentication;

    public function __construct(RouterInterface $router, AuthenticationInterface $authentication)
    {
        $this->router = $router;
        $this->authentication = $authentication;
    }

    public function handle(RequestInterface $request): ResponseInterface
    {
        $user = $this->authentication->authenticate($request);

        $request = $request->withAttribute('user', $user);

        $controller = $this->router->route($request);

        $body = $controller($request);

        return new Response(200, '1.1', [], $body);
    }
}