<?php
namespace Framework\DependencyInjection;

use Framework\Kernel\Kernel;
use Framework\Routing\Router;
use Framework\Templating\TemplateEngine;

class Container
{
    public function createKernel(): \Framework\Kernel\Kernel
    {
        // pad naar templates map
        $templateEngine = new \Framework\Templating\TemplateEngine(__DIR__ . '/../../../templates');

        $routes = [
            '/'            => fn() => $templateEngine->render('Home.html'),
            '/boeken'      => fn() => $templateEngine->render('Boeken.html'),
            '/boek-info'   => fn() => $templateEngine->render('BookInfo.html'),
            '/login'       => fn() => $templateEngine->render('Login.html'),
            '/registreren' => fn() => $templateEngine->render('Registration.html'),
        ];
        $router = new \Framework\Routing\Router($routes);
        return new \Framework\Kernel\Kernel($router);
    }
}