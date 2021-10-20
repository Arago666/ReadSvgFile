<?php

namespace App\src;

use App\interfaces\TableFileReaderInterface;
use SplFileObject;

class ReadFileFormatCsv implements TableFileReaderInterface
{
    public function read(SplFileObject $file): \Generator
    {
        $titleColumns = static::readTitleColumnsFromFirstRow($file);
        $rowId = 1;

        while (($row = static::readOneRow($file)) !== false) {
            if (static::rowIsEmpty($row)) {
                continue;
            }

            yield static::createRow($row, (string)$rowId, $titleColumns);
            $rowId++;
        }
    }

    /**
     * @return array[]
     */
    private static function readTitleColumnsFromFirstRow(SplFileObject $file): array
    {
        return static::readOneRow($file);
    }

    /**
     * @return array[]
     */
    private static function readOneRow(SplFileObject $file): ?array
    {
        return $file->fgetcsv();
    }

    private static function rowIsEmpty(array $row): bool
    {
        return is_null($row[0]);
    }

    private static function createRow(array $row, string $rowId, array $titleColumns): Row
    {
        $rowClass = new Row($rowId);

        foreach ($titleColumns as $index => $title) {
            $cell = new Cell((string) $index, (string) $title, (string) $row[$index]);
            $rowClass->addCells($cell);
        }

        return $rowClass;
    }
}