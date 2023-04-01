<?php

namespace App\Tests\Service;

use Imported\AppBundle\Services\Queue\DefaultDbQueue;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Imported\AppBundle\Services\Executor\CsvFileExecutor;
use Exception;
use Pimcore\Bootstrap;

class CsvFileExecutorTest extends KernelTestCase
{
    public function preparationObjectCreationElement(): array
    {
        return [
            'Executor Failure Path' => ['path' => 'Cars-22.csv','key' => 2]
        ];
    }
    /**
     * @dataProvider preparationObjectCreationElement
     * @param string $path
     * @param int $key
     */
    public function testCsvFileExecutor(string $path, int $key)
    {
        $this->expectException(Exception::class);
        $kernel = Bootstrap::kernel();
        $queueService = $kernel->getContainer()->get(DefaultDbQueue::class);
        $csvFileExecutor=new CsvFileExecutor([],$queueService);
        $csvFileExecutor->executeFile($path,$key);
    }

}
