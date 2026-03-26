<?php
namespace App\Controllers;
class BookInfoController
{
    public function index():string
    {
        return file_get_contents(__DIR__ . '/../../../templates/BookInfo.html');
    }
}