<?php
namespace Framework\DependencyInjection;

use App\Controllers\AdminController;
use App\Controllers\BookController;
use App\Controllers\BookEditController;
use App\Controllers\BookInfoController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\LogoutController;
use App\Http\Session;
use App\Repository\UserRepository;
use App\Repository\BookRepository;
use App\Security\Authenticator;
use Framework\AccessControl\AuthenticatorMiddleware;
use Framework\AccessControl\AuthorizationService;
use Framework\AccessControl\FireWall;
use Framework\AccessControl\FireWallMiddleware;
use Framework\Database\Connection;
use Framework\Kernel\Kernel;
use Framework\Routing\Router;
use Framework\Templating\TemplateEngine;

class Container
{
    public function createKernel(): Kernel
    {
        $dbPath = __DIR__ . '/../../../database.sqlite';
        $connection = new Connection($dbPath);

        $session = new Session();

        $userProvider = new UserRepository($connection);
        $bookRepository = new BookRepository($connection);

        $templateEngine = new TemplateEngine(__DIR__ . '/../../../templates');

        // Middleware
        $authService = new AuthorizationService();
        $authenticator = new Authenticator($userProvider, $session);
        $firewall = new FireWall($authService);
        $middlewares = [
            new AuthenticatorMiddleware($authenticator),
            new FirewallMiddleware($firewall),
        ];

        // Boek-controllers
        $bookController = new BookController($templateEngine, $bookRepository);
        $bookInfoController = new BookInfoController($templateEngine, $bookRepository);
        $bookEditController = new BookEditController($templateEngine, $bookRepository);

        $adminController = new AdminController($templateEngine);

        //registratie-controllers
        $registerController = new RegisterController(
            $templateEngine,
            $userProvider
        );

        $loginController = new LoginController(
            $templateEngine,
            $userProvider,
            $session
        );

        $logoutController = new LogoutController($session);

        //routes
        $routes = [
            '/' => function($request) use ($templateEngine) {
                $user = $request->getAttribute('user');
                return $templateEngine->render('Home.html', [
                    'user' => $user
                ]);
            },

            //boeken
            '/boeken'      => [$bookController, 'index'],
            '/boek-info'   => [$bookInfoController, 'index'],
            '/boek-bewerken'   => [$bookEditController, 'edit'],
            '/boek-bewerken-verwerken'   => [$bookEditController, 'update'],

            //registratie
            '/login'       => $loginController,
            '/registreren' => $registerController,
            '/logout'      => $logoutController,

            //admin
            '/admin'      => [$adminController, 'index'],


        ];

        $router = new Router($routes);
        return new Kernel($router, $middlewares);
    }
}