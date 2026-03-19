<?php
namespace Framework\Kernel;

use Framework\Http\RequestInterface;
use Framework\Http\ResponseInterface;
use Framework\Routing\Router;

class Kernel implements KernelInterface{

    public function handle(RequestInterface $request): ResponseInterface
    {
        $routes = [
            '/'             => function() { return file_get_contents(__DIR__ . '/../views/Home.html'); },
            '/boeken'       => function() { return file_get_contents(__DIR__ . '/../views/Boeken.html'); },
            '/boek-info'    => function() { return file_get_contents(__DIR__ . '/../views/BookInfo.html'); },
            '/login'        => function() { return file_get_contents(__DIR__ . '/../views/Login.html'); },
            '/registreren'  => function() { return file_get_contents(__DIR__ . '/../views/Registration.html'); },
            '/admin'        => function() { return file_get_contents(__DIR__ . '/../views/Admin.html'); },
        ];

        $router = new Router($routes);

        $controller = $router->route($request);

        return $controller();
    }
}
