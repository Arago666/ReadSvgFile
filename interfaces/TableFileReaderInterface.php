<?php

namespace App\interfaces;

interface TableFileReaderInterface
{
    public function read(\SplFileObject $file);
}