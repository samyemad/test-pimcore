<?php

namespace App\Tests\Service;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Imported\AppBundle\Services\Provider\ProviderInterface;
use Imported\AppBundle\Services\Executor\FileExecutorInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Imported\AppBundle\Services\Import\Preparation\CsvImportPreparation;

class CsvImportPreparationTest extends KernelTestCase
{

    public function preparationDataProvider(): array
    {
        return [
            'Preparation 1' => ['data' => ['id' => 2]],
        ];
    }
    /**
     * @dataProvider preparationDataProvider
     * @param array $data
     */
    public function testCsvImportPreparation(array $data)
    {
        $importPreparation=new CsvImportPreparation($this->getAssetProviderMock(),$this->getCsvFileExecutorMock(),
            $this->getEventDispatcherMock(),$this->getLoggerMock());
        $this->assertTrue($importPreparation->process($data));
    }
    private function getAssetProviderMock(): ProviderInterface
    {
        $mock = $this
            ->getMockBuilder(ProviderInterface::class)
            ->getMock();
        $mock->expects(self::once())
            ->method('process')
            ->willReturn(PIMCORE_WEB_ROOT.'/car-export.csv');
        return $mock;
    }

    private function getCsvFileExecutorMock(): FileExecutorInterface
    {
        $mock = $this
            ->getMockBuilder(FileExecutorInterface::class)
            ->getMock();
        $mock->expects(self::once())
            ->method('executeFile')
            ->willReturn('Asset-2');
        return $mock;
    }

    private function getLoggerMock(): LoggerInterface
    {
        return  $this
            ->getMockBuilder(LoggerInterface::class)
            ->getMock();
    }

    private function getEventDispatcherMock(): EventDispatcherInterface
    {
        return  $this
            ->getMockBuilder(EventDispatcherInterface::class)
            ->getMock();
    }
}
