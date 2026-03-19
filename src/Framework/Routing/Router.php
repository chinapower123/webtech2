<?php

namespace Framework\Routing;

use Framework\Http\RequestInterface;

class Router implements RouterInterface{

    private array $routes = [];

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    function route(RequestInterface $request): callable
    {
        $uri = $request->getUri();
        $path = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes as $route => $handler) {
            if($path === $route) {
                return $handler;
            }
        }

        return function(){
            return "404 page not found";
        };
    }
}
