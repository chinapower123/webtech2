<?php

namespace App\Controllers;

use App\Http\Session;

class LogoutController
{
    public function __construct(
        private Session $session
    ) {}

    public function __invoke($request)
    {
        $this->session->remove('user');

        header('Location: /');
        exit;
    }
}