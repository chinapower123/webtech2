<?php
namespace Framework\DependencyInjection;

use App\Controllers\BookController;
use App\Controllers\BookInfoController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Http\Session;
use App\Repository\UserRepository;
use App\Security\Authenticator;
use Framework\Database\Connection;
use Framework\Kernel\Kernel;
use Framework\Routing\Router;
use Framework\Templating\TemplateEngine;
use PDO;

class Container
{
    public function createKernel(): Kernel
    {
        $dbPath = __DIR__ . '/../../../database.sqlite';
        $connection = new Connection($dbPath);

        $session = new Session();

        $userProvider = new UserRepository($connection);

        $templateEngine = new TemplateEngine(__DIR__ . '/../../../templates');
        $authenticator = new Authenticator($userProvider, $session);

        //controllers
        $registerController = new RegisterController($templateEngine);
        $bookController = new BookController($templateEngine);
        $bookInfoController = new BookInfoController($templateEngine);
        $loginController = new LoginController(
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

            '/boeken'      => [$bookController, 'index'],
            '/boek-info' => [$bookInfoController, 'index'],
            '/login'       => $loginController,
            '/registreren' => [$registerController, 'index'],
        ];

        $router = new Router($routes);
        return new Kernel($router, $authenticator);
    }
}