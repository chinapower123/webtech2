<?php

namespace App\Controllers;

use App\Repository\UserRepository;
use Framework\Templating\TemplateEngine;

class RegisterController{
    public function __construct(
        private TemplateEngine $templateEngine,
        private UserRepository $userRepository
    ) {}

    public function __invoke($request)
    {
        if ($request->getMethod() === 'POST') {
            $username = $request->getPostData('username');
            $password = $request->getPostData('password');
            $passwordConfirm = $request->getPostData('password_confirm');

            if ($username && $password) {

                if ($password !== $passwordConfirm) {
                    die("Fout: Wachtwoorden komen niet overeen!");
                }

                $this->userRepository->create($username, $password);

                header('Location: /login');
                exit;
            }
        }
        return $this->templateEngine->render('Registration.html');
    }
}