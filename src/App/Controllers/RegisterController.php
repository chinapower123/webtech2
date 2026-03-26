<?php
namespace App\Controllers;
class RegisterController
{
    public function index():string
    {
        return file_get_contents(__DIR__ . '/../../../templates/Registration.html');
    }
}