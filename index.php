<?php
declare(strict_types = 1);

use app\src\ReadFileFormatCsv;

include realpath("engine/Autoload.php");
spl_autoload_register([new Autoload(), 'loadClass']);

try {
    $filePath = __DIR__ . '/test.csv';
    $file = new SplFileObject($filePath);
    $file->setCsvControl(';');
    foreach(ReadFileFormatCsv::read($file) as $fileData) {
        var_dump($fileData);
    }

} catch (\Exception $exception) {
    echo $exception->getMessage();
    var_dump($exception->getTrace());
}
