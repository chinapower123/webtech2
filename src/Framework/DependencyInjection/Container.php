<?php
namespace Framework\DependencyInjection;

use Framework\Kernel\Kernel;
use Framework\Routing\Router;
use Framework\Templating\TemplateEngine;

class Container
{
    public function createKernel(): Kernel
    {
        // pad naar templates map
        $templateEngine = new TemplateEngine(__DIR__ . '/../../../templates');

        $routes = [
            '/'            => fn() => $templateEngine->render('Home.html'),
            '/boeken'      => fn() => $templateEngine->render('Boeken.html'),
            '/boek-info'   => fn() => $templateEngine->render('BookInfo.html'),
            '/login'       => fn() => $templateEngine->render('Login.html'),
            '/registreren' => fn() => $templateEngine->render('Registration.html'),
        ];
        $router = new Router($routes);
        return new Kernel($router);
    }
}