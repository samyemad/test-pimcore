<?php

namespace Imported\AppBundle\Services\Import\Process;

use Imported\AppBundle\Services\Creation\CreationElementInterface;
use Psr\Log\LoggerInterface;
use Imported\AppBundle\Services\Queue\DbQueueInterface;
use Imported\AppBundle\Services\Mapping\MappingInterface;

class CsvImportProcess implements ImportProcessInterface
{
    /**
     * @var DbQueueInterface
     */
    protected DbQueueInterface $dbQueue;

    /**
     * @var CreationElementInterface
     */
    protected CreationElementInterface $creationElement;
    /**
     * @var MappingInterface
     */
    protected  MappingInterface $mapping;
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    public function __construct(
        CreationElementInterface $objectCreationElement,
        MappingInterface $mappingConfiguration,
        DbQueueInterface $defaultDbQueue,
        LoggerInterface $logger
    ) {
        $this->mapping = $mappingConfiguration;
        $this->creationElement = $objectCreationElement;
        $this->dbQueue = $defaultDbQueue;
        $this->logger = $logger;
     }
    public function process(int $queueId): void
    {
        try {
            $queueItem = $this->dbQueue->getQueueEntryById($queueId);
            if (empty($queueItem)) {
                return ;
            }
            $data = $queueItem['data'];
            $data = json_decode($data, true);
            $object = $this->creationElement->process();
            $this->mapping->process($object, $data);
            $this->dbQueue->deleteQueueItemById($queueId);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
