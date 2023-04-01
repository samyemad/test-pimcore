<?php

namespace App\Tests\Service;

use Imported\AppBundle\Services\Queue\DbQueueInterface;
use Pimcore\Model\DataObject\Car;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Imported\AppBundle\Services\Import\Process\CsvImportProcess;
use Imported\AppBundle\Services\Creation\CreationElementInterface;
use Imported\AppBundle\Services\Mapping\MappingInterface;

class CsvImportProcessTest extends KernelTestCase
{

    public function preparationDataQueue(): array
    {
        return [
            'Queue 1' => ['id' => 1],
        ];
    }
    /**
     * @dataProvider preparationDataQueue
     * @param int $id
     */
    public function testCsvImportProcess(int $id)
    {
        $csvImportProcess=new CsvImportProcess($this->getCreationElementMock(),$this->getMappingConfigurationMock(),
            $this->getDefaultDbQueueMock(),$this->getLoggerMock());

        $csvImportProcess->process($id);
    }

    private function getMappingConfigurationMock(): MappingInterface
    {
        $mock = $this
            ->getMockBuilder(MappingInterface::class)
            ->getMock();
        $mock->expects(self::once())->method('process');
        return $mock;
    }

    private function getCreationElementMock(): CreationElementInterface
    {
        $mock = $this
            ->getMockBuilder(CreationElementInterface::class)
            ->getMock();
        $mock->expects(self::once())
            ->method('process')
            ->willReturn(new Car());
        return $mock;
    }

    private function getLoggerMock(): LoggerInterface
    {
        return  $this
            ->getMockBuilder(LoggerInterface::class)
            ->getMock();
    }

    private function getDefaultDbQueueMock(): DbQueueInterface
    {
       $mock= $this
            ->getMockBuilder(DbQueueInterface::class)
            ->getMock();
        $mock->expects(self::once())
            ->method('getQueueEntryById')
            ->willReturn(['id' => 1,'data' => $this->getDataJson()]);;
        $mock->expects(self::once())->method('deleteQueueItemById');
        return $mock;
    }

    private function getDataJson(): string
    {
        $data=['articleNumber' => 'a82366da-c727','manufacturer' => 'Ford'];
        return json_encode($data,true);
    }
}
