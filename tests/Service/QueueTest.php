<?php

namespace App\Tests\Service;


use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Imported\AppBundle\Services\Queue\DefaultDbQueue;

class QueueTest extends KernelTestCase
{

    public function testQueue()
    {
        $kernel = \Pimcore\Bootstrap::kernel();
        $queueService = $kernel->getContainer()->get(DefaultDbQueue::class);
        $queueService->addItemToQueue('test data','Asset-2');

        $count = $queueService->getQueueItemCountByGroup('Asset-2');
        $this->assertEquals($count, 1 );

        $queueIds = $queueService->getAllQueueIdsByGroup('Asset-2',1,0);
        $entry = $queueService->getQueueEntryById($queueIds[0]);

        $this->assertEquals($entry['data'], 'test data');
        $queueService->deleteQueueItemById($queueIds[0]);

        $count = $queueService->getQueueItemCountByGroup('Asset-2');
        $this->assertEquals(0, $count);
    }

}
