<?php

namespace Framework\Routing;

use Framework\Http\RequestInterface;

class Router implements RouterInterface{

    private array $routes = [];

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function route(RequestInterface $request): callable
    {
        $path = $request->getUri()->getPath();

        foreach ($this->routes as $route => $handler) {
            if ($path === $route) {
                return $handler;
            }
        }

        return function() {
            return "404 page not found";
        };
    }
}
