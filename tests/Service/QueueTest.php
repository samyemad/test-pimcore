<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Imported\AppBundle\Services\Queue\DefaultDbQueue;
use Pimcore\Bootstrap;

class QueueTest extends KernelTestCase
{

    public function testQueue()
    {
        $kernel = Bootstrap::kernel();
        $queueService = $kernel->getContainer()->get(DefaultDbQueue::class);
        $queueService->addItemToQueue('test data','Asset-2');

        $count = $queueService->getQueueItemCountByGroup('Asset-2');
        $this->assertEquals(1, $count);

        $queueIds = $queueService->getAllQueueIdsByGroup('Asset-2',1,0);
        $entry = $queueService->getQueueEntryById($queueIds[0]);

        $this->assertEquals('test data', $entry['data']);
        $queueService->deleteQueueItemById($queueIds[0]);

        $count = $queueService->getQueueItemCountByGroup('Asset-2');
        $this->assertEquals(0, $count);
    }

}
