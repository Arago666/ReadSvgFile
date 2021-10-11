<?php

namespace app\src;

final class Row
{
    private string $id;
    private array $cells;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCells(): array
    {
        return $this->cells;
    }

    public function addCells(Cell $cell): self
    {
        $this->cells[] = $cell;

        return $this; //???
    }

}