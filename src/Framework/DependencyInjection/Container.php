<?php
namespace Framework\DependencyInjection;

use App\Controllers\BookController;
use App\Controllers\BookInfoController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\LogoutController;
use App\Http\Session;
use App\Repository\UserRepository;
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
    //test
    public function createKernel(): Kernel
    {
        $dbPath = __DIR__ . '/../../../database.sqlite';
        $connection = new Connection($dbPath);

        $session = new Session();

        $userProvider = new UserRepository($connection);

        $templateEngine = new TemplateEngine(__DIR__ . '/../../../templates');

        //Middleware
        $authService = new AuthorizationService();
        $authenticator = new Authenticator($userProvider, $session);
        $firewall = new FireWall($authService);
        $middlewares = [
            new FirewallMiddleware($firewall),
            new AuthenticatorMiddleware($authenticator),
        ];

        //controllers
        $registerController = new RegisterController(
            $templateEngine,
            $userProvider
        );

        $bookController = new BookController($templateEngine);

        $bookInfoController = new BookInfoController($templateEngine);

        $loginController = new LoginController(
            $templateEngine,
            $userProvider,
            $session
        );

        $logoutController = new LogoutController($session);

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
            '/registreren' => $registerController,
            '/logout'      => $logoutController,
        ];

        $router = new Router($routes);
        return new Kernel($router, $middlewares);
    }
}