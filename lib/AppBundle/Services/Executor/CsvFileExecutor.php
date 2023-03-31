<?php

namespace Imported\AppBundle\Services\Executor;

use Imported\AppBundle\Services\Provider\AssetProvider;
use Imported\AppBundle\Services\Queue\DbQueueInterface;

class CsvFileExecutor implements FileExecutorInterface
{
    /**
     * @var bool
     */
    protected bool $skipFirstRow;
    /**
     * @var string
     */
    protected string $delimiter;
    /**
     * @var string
     */
    protected string $enclosure;
    /**
     * @var string
     */
    protected string  $escape;
    /**
     * @var DbQueueInterface
     */
    protected DbQueueInterface $dbQueue;

    public function __construct(array $executorConfig,DbQueueInterface $defaultDbQueue)
    {
        $this->skipFirstRow = $executorConfig['skipFirstRow'] ?? false;
        $this->delimiter = $executorConfig['delimiter'] ?? ',';
        $this->enclosure = $executorConfig['enclosure']  ?? '"';
        $this->escape = $executorConfig['escape'] ?? '\\';
        $this->dbQueue = $defaultDbQueue;
    }

    public function executeFile(string $path,int $key): string
    {
        $groupName=AssetProvider::GROUP_KEY.$key;
        if ($this->checkValidFile($path)) {
            $this->executeFileAndProcessItemToQueue($path,$groupName);
        }
        return $groupName;
    }
    /**
     * read data from the file path and then add row by row to the queue
     * @param string $path
     * @param string $groupName
     * @return void
     */
    protected function executeFileAndProcessItemToQueue(string $path,string $groupName): void
    {
        if (($handle = fopen($path, 'r')) !== false) {
            if ($this->skipFirstRow) {
                $data = fgetcsv($handle, 0, $this->delimiter, $this->enclosure, $this->escape);
            }
            while (($data = fgetcsv($handle, 0, $this->delimiter, $this->enclosure, $this->escape)) !== false) {
               $this->dbQueue->addItemToQueue(json_encode($data),$groupName);
            }
            fclose($handle);
        }
    }
    public function checkValidFile(string $path): bool
    {
        $csvTypes = [ 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv'];
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $path);
        finfo_close($fileInfo);
        return in_array($mimeType, $csvTypes);
    }


}
