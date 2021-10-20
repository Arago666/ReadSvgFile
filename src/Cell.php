<?php

namespace App\src;

final class Cell
{
    private string $id;
    private string $title;
    private string $value;

    public function __construct(string $id, string $title, string $value)
    {
        $this->id = $id;
        $this->title = $title;
        $this->value = $value;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}