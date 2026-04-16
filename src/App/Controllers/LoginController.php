<?php
namespace App\Controllers;

use Framework\Http\RequestInterface;
use Framework\Http\SessionInterface;
use Framework\AccessControl\UserProviderInterface;
use Framework\Templating\TemplateEngine;

class LoginController
{
    private TemplateEngine $templateEngine;
    private UserProviderInterface $userProvider;
    private SessionInterface $session;

    public function __construct(
        TemplateEngine $templateEngine,
        UserProviderInterface $userProvider,
        SessionInterface $session
    ) {
        $this->templateEngine = $templateEngine;
        $this->userProvider = $userProvider;
        $this->session = $session;
    }

    public function __invoke(RequestInterface $request): string
    {
        $error = null;

        if ($request->getMethod() === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userProvider->get($username);

            if (!$user->isAnonymous() && password_verify($password, $user->getPasswordHash())) {
                $this->session['user'] = $user->getUsername();
                header('Location: /');
                exit;
            }

            $error = "Verkeerd wachtwoord of gebruikersnaam!";
        }
        return $this->templateEngine->render('Login.html', [
            'user'  => $request->getAttribute('user'),
            'error' => $error
        ]);
    }
}