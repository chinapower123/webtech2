<?php
namespace Framework\Kernel;

use Framework\Http\RequestInterface;
use Framework\Http\ResponseInterface;
use Framework\Routing\Router;

class Kernel implements KernelInterface{

    public function handle(RequestInterface $request): ResponseInterface
    {
        $routes = [
            '/'             => function() { return file_get_contents(__DIR__ . '/../templates/Home.html'); },
            '/boeken'       => function() { return file_get_contents(__DIR__ . '/../templates/Boeken.html'); },
            '/boek-info'    => function() { return file_get_contents(__DIR__ . '/../templates/BookInfo.html'); },
            '/login'        => function() { return file_get_contents(__DIR__ . '/../templates/Login.html'); },
            '/registreren'  => function() { return file_get_contents(__DIR__ . '/../templates/Registration.html'); },
            '/admin'        => function() { return file_get_contents(__DIR__ . '/../templates/Admin.html'); },
        ];

        $router = new Router($routes);

        $controller = $router->route($request);

        return $controller();
    }
}
