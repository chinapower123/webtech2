<?php
namespace Framework\DependencyInjection;

use App\Http\Session;
use App\Repository\UserRepository;
use App\Security\Authenticator;
use Framework\Kernel\Kernel;
use Framework\Routing\Router;
use Framework\Templating\TemplateEngine;
use PDO;

class Container
{
    public function createKernel(): Kernel
    {
        $dbPath = __DIR__ . '/../../../database.sqlite';

        $connection = new \Framework\Database\Connection($dbPath);

        $session = new Session();

        $userProvider = new UserRepository($connection);

        $templateEngine = new TemplateEngine(__DIR__ . '/../../../templates');
        $authenticator = new Authenticator($userProvider, $session);

        $loginController = new \App\Controllers\LoginController(
            $templateEngine,
            $userProvider,
            $session
        );

        $routes = [
            '/' => function($request) use ($templateEngine) {
                $user = $request->getAttribute('user');

                // We geven de user mee als array aan de template
                return $templateEngine->render('Home.html', [
                    'user' => $user
                ]);
            },

            '/boeken'      => fn() => $templateEngine->render('Boeken.html'),
            '/boek-info'   => fn() => $templateEngine->render('BookInfo.html'),
            '/login'       => $loginController,
            '/registreren' => fn() => $templateEngine->render('Registration.html'),
        ];

        $router = new Router($routes);

        return new Kernel($router, $authenticator);
    }
}