<?php
namespace Framework\Kernel;

use Framework\Http\Request;
use Framework\Http\RequestInterface;
use Framework\Http\Response;
use Framework\Http\ResponseInterface;
use Framework\Routing\Router;

class Kernel implements KernelInterface
{
    public function handle(RequestInterface $request): ResponseInterface
    {
        $routes = [
            '/'            => fn() => file_get_contents(__DIR__ . '/../../../templates/Home.html'),
            '/boeken'      => fn() => file_get_contents(__DIR__ . '/../../../templates/Boeken.html'),
            '/boek-info'   => fn() => file_get_contents(__DIR__ . '/../../../templates/BookInfo.html'),
            '/login'       => fn() => file_get_contents(__DIR__ . '/../../../templates/Login.html'),
            '/registreren' => fn() => file_get_contents(__DIR__ . '/../../../templates/Registration.html'),
            '/admin'       => fn() => file_get_contents(__DIR__ . '/../../../templates/Admin.html'),
        ];

        $router = new Router($routes);
        $controller = $router->route($request);
        $body = $controller();

        return new Response(200, '1.1', [], $body);
    }
}