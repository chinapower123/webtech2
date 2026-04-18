<?php
namespace App\Entity;

class Review
{
    public int $id;
    public int $book_id;
    public int $user_id;
    public int $score;
    public string $text;
}