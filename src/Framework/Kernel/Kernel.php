<?php

namespace Framework\Kernel;

use Framework\AccessControl\AuthenticationInterface;
use Framework\AccessControl\FireWall;
use Framework\AccessControl\FirewallInterface;
use Framework\Http\RequestInterface;
use Framework\Http\Response;
use Framework\Http\ResponseInterface;
use Framework\Routing\RouterInterface;

class Kernel implements KernelInterface
{
    private RouterInterface $router;
    private int $count = 0;
    private array $middlewares;
    public function __construct(RouterInterface $router, array $middlewares)
    {
        $this->router = $router;
        $this->middlewares = $middlewares;
    }

    public function handle(RequestInterface $request): ResponseInterface
    {
        if ($this->count >= count($this->middlewares)) {
            $controller = $this->router->route($request);
            $body = $controller($request);
            return new Response(200, '1.1', [], $body);
        }

        $middleware = $this->middlewares[$this->count];
        $this->count++;

        return $middleware->process($request, $this);
    }
}