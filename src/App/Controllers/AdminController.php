<?php
namespace App\Controllers;
class AdminController
{
    public function index():string
    {
        return file_get_contents(__DIR__ . '/../../../templates/Admin.html');
    }
}