<?php

trait Memory {

    private int $memoryLimitInMb = 1000;

    public function IsMemoryLimit(): bool{
        if(memory_get_usage() > $this->memoryLimitInMb * 1024 * 1024){
            return true;
        }
        return false;
    }

}

class ReadFile
{
    public string $filePath;
    public array $data;
}

class ReadFileFormatCsv extends ReadFile
{
    use Memory;

    public int $countFileColumns;
    public array $titleFileColumns;
    public bool $statusReadFile;
    public int $countReadRows;

    /**
     * ReadFileFormatCsv constructor.
     * @param $filePath
     * @param $titleFileColumns
     * @param $countFileColumns
     * @param $statusReadFile
     * @param $countReadRows
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $this->titleFileColumns = $this->getTitleFileColumns();
        $this->countFileColumns = $this->getCountFileColumns();
        $this->statusReadFile = false;
        $this->countReadRows = 0;
    }

    private function getTitleFileColumns(): array {
        $handle = fopen($this->filePath, "r");
        $titleFileColumns = $this->readOneRow($handle);
        fclose($handle);
        return $titleFileColumns;
    }

    private function getCountFileColumns(): int {
        return count($this->titleFileColumns);
    }

    public function read(): void {
        $handle = fopen($this->filePath, "r");
        $this->skipFirstRow($handle);
        $this->writeDataToThisObject($handle);
        fclose($handle);
    }

    public function readOneRow($handle): array|bool {
        return fgetcsv($handle, 0, ',');
    }

    public function skipFirstRow($handle): void {
        $this->readOneRow($handle);
    }

    public function writeDataToThisObject($handle): void {
        while ( ($row = $this->readOneRow($handle)) == true) {
            if( $this->IsMemoryLimit()){
                return;
            }
            $this->addRowInData($row);
        }
        $this->fileReadSuccessfully();
    }

    private function addRowInData($row): void {
        for($i = 0; $i < $this->countFileColumns; $i++) {
            $data[$this->titleFileColumns[$i]] = $row[$i];
        }
        $this->data[] = $data;
        $this->countReadRows++;
    }

    private function fileReadSuccessfully(): void {
        $this->statusReadFile = true;
    }
}

$filePath = __DIR__ . '/test.csv';
$file = new ReadFileFormatCsv($filePath);
$file->read();
var_dump($file);