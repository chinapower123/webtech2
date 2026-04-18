<?php
namespace App\Entity;

class Book
{
    public ?int $id = null;
    public string $title;
    public string $author;
    public string $description;
    public int $genre_id;
}