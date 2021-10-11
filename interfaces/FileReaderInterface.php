<?php

namespace app\interfaces;

interface FileReaderInterface
{
    public static function read(\SplFileObject $file);
}