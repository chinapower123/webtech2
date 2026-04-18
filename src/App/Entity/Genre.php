<?php
namespace App\Entity;

class Genre
{
    public ?int $id = null;
    public string $name;

    public function getId(): ?int
    {
        return $this->id;
    }
}