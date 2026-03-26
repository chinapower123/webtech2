<?php
namespace App\Controllers;
class LoginController
{
    public function index():string
    {
        return file_get_contents(__DIR__ . '/../../../templates/Login.html');
    }
}