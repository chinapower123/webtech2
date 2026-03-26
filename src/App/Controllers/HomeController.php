<?php
namespace App\Controllers;
class HomeController
{
    public function index():string
    {
        return file_get_contents(__DIR__ . '/../../../templates/Boeken.html');
    }
}