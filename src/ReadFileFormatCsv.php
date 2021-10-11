<?php

namespace app\src;

use app\src\Row;
use app\src\Cell;
use app\interfaces\FileReaderInterface;

class ReadFileFormatCsv implements FileReaderInterface
{
    public static function read(\SplFileObject $file): \Generator
    {
        $titleColumns = static::readTitleColumnsFromFirstRow($file);
        $rowId = 1;
        while ( ($row = static::readOneRow($file)) == true) {
            if(static::rowIsNotEmpty($row)) {
                yield static::createObjectFromRow($row, (string)$rowId, $titleColumns);
            }
            $rowId++;
        }
    }

    private static function readTitleColumnsFromFirstRow(\SplFileObject $file): array
    {
        $titleColumns = static::readOneRow($file);

        return $titleColumns;
    }

    private static function readOneRow(\SplFileObject $file): array|null
    {
        return $file->fgetcsv();
    }

    private static function rowIsNotEmpty(array $row): bool
    {
        return !is_null($row[0]);
    }

    private static function createObjectFromRow(array $row, string $rowId, array $titleFileColumns): Row
    {
        $rowClass = new Row($rowId);
        for ($i = 0; $i < count($titleFileColumns); $i++) {
            $cell = new Cell((string)$i, $titleFileColumns[$i], $row[$i]);
            $rowClass->addCells($cell);
        }

        return $rowClass;
    }
}