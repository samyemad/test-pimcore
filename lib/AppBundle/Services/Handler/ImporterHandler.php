<?php

namespace Imported\AppBundle\Services\Handler;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Imported\AppBundle\Message\ImporterMessage;
use Imported\AppBundle\Services\Import\Process\ImportProcessInterface;

class ImporterHandler implements MessageHandlerInterface
{
    protected ImportProcessInterface $importProcess;

    public function __construct(ImportProcessInterface $csvImportProcess)
    {
       $this->importProcess = $csvImportProcess;
    }
    public function __invoke(ImporterMessage $message):void
    {
        foreach ($message->getIds() as $id)
        {
            $this->importProcess->process($id);
        }
    }



}
