<?php

class Autoload
{
    public function loadClass($className): void
    {
        $fileName = str_replace(['App','\\'], [dirname(__DIR__), DIRECTORY_SEPARATOR], $className . ".php");

        if(file_exists($fileName)) {
            include $fileName;
        }
    }
}