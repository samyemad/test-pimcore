<?php

namespace Imported\AppBundle\EventListener;

use Imported\AppBundle\Event\ProcessImportEvent;
use Imported\AppBundle\Services\Queue\DbQueueInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Imported\AppBundle\Message\ImporterMessage;

class DataProcessImportListener
{
    /**
     * @var DbQueueInterface
     */
    protected DbQueueInterface $dbQueue;
    /**
     * @var MessageBusInterface
     */
    protected MessageBusInterface $messageBus;
    /**
     * @var array
     */
    protected array $messageConfig;

    public function __construct(array $messageConfig, DbQueueInterface $defaultDbQueue,MessageBusInterface $messageBus)
    {
       $this->dbQueue = $defaultDbQueue;
       $this->messageBus = $messageBus;
       $this->messageConfig = $messageConfig;
    }
    /**
     * process the import based on the group name and dispatch the message
     * @param ProcessImportEvent $event
     * @return void
     */
    public function process(ProcessImportEvent $event):void
    {
       $queueCount=$this->dbQueue->getQueueItemCountByGroup($event->getGroupName());
       $numOfProcessedRows=$this->messageConfig['numOfProcessedRows'];
       $size=ceil($queueCount/$numOfProcessedRows);
      for($i = 0;$i< $size; $i++)
      {
          $offset = $i * $numOfProcessedRows;
          $ids=$this->dbQueue->getAllQueueIdsByGroup($event->getGroupName(),$numOfProcessedRows,$offset);
          $this->messageBus->dispatch(new ImporterMessage($ids));
      }
    }
}
