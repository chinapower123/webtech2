<?php
namespace Framework\DependencyInjection;

use App\Controllers\AdminController;
use App\Controllers\BookController;
use App\Controllers\BookEditController;
use App\Controllers\BookInfoController;
use App\Controllers\GenreController;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\LogoutController;
use App\Controllers\ReviewController;
use App\Entity\Book;
use App\Entity\Genre;
use App\Entity\Review;
use App\Http\Session;
use App\Repository\GenreRepository;
use App\Repository\ReviewRepository;
use App\Repository\UserRepository;
use App\Repository\BookRepository;
use App\Security\Authenticator;
use Framework\AccessControl\AuthenticatorMiddleware;
use Framework\AccessControl\AuthorizationService;
use Framework\AccessControl\FireWall;
use Framework\AccessControl\FireWallMiddleware;
use Framework\Database\Connection;
use Framework\Database\DataMapper;
use Framework\Database\IdentityMap;
use Framework\Kernel\Kernel;
use Framework\Routing\Router;
use Framework\Templating\TemplateEngine;
use Symfony\Component\DependencyInjection\Tests\Compiler\H;

class Container
{
    public function createKernel(): Kernel
    {
        $dbPath = __DIR__ . '/../../../database.sqlite';
        $connection = new Connection($dbPath);

        $session = new Session();


        $bookDataMapper = new DataMapper(new IdentityMap(), $connection, 'books', Book::class);
        $genreDataMapper = new DataMapper(new IdentityMap(), $connection, 'genres', Genre::class);
        $reviewDataMapper = new DataMapper(new IdentityMap(), $connection, 'reviews', Review::class);

        $bookRepository = new BookRepository($bookDataMapper);
        $genreRepository = new GenreRepository($genreDataMapper);
        $reviewRepository = new ReviewRepository($reviewDataMapper);


        $userProvider = new UserRepository($connection);

        $templateEngine = new TemplateEngine(__DIR__ . '/../../../templates');

        // Middleware
        $authService = new AuthorizationService();
        $authenticator = new Authenticator($userProvider, $session);
        $firewall = new FireWall($authService);
        $middlewares = [
            new AuthenticatorMiddleware($authenticator),
            new FirewallMiddleware($firewall),
        ];

        //Home-controller
        $homeController = new HomeController($templateEngine, $bookRepository);

        // Boek-controllers
        $bookController = new BookController($templateEngine, $bookRepository);
        $bookInfoController = new BookInfoController($templateEngine, $bookRepository, $reviewRepository);
        $bookEditController = new BookEditController($templateEngine, $bookRepository, $genreRepository);

        //admin-controllers
        $adminController = new AdminController($templateEngine, $bookRepository);

        //review
        $reviewController = new ReviewController($reviewRepository);

        //genre-controllers
        $genreController = new GenreController($templateEngine, $genreRepository);

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
            '/' => [$homeController, 'home'],

            //boeken
            '/boeken'      => [$bookController, 'index'],
            '/boek-info'   => [$bookInfoController, 'index'],
            '/boek-bewerken'   => [$bookEditController, 'edit'],
            '/boek-bewerken-verwerken'   => [$bookEditController, 'update'],
            '/boek-toevoegen'   => [$bookEditController, 'create'],
            '/boek-toevoegen-verwerken'   => [$bookEditController, 'store'],
            '/boek-verwijderen'   => [$bookEditController, 'delete'],

            //genre
            '/genre-beheer' => [$genreController, 'index'],
            '/genre-toevoegen'   => [$genreController, 'create'],
            '/genre-toevoegen-verwerken'   => [$genreController, 'store'],
            '/genre-verwijderen'   => [$genreController, 'delete'],

            //reviews
            '/review-verwijderen'   => [$reviewController, 'delete'],


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