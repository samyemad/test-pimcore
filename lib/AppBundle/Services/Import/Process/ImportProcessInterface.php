<?php

namespace Imported\AppBundle\Services\Import\Process;

interface ImportProcessInterface
{
    /**
     * Process the import queue and map the data to the object
     * @param int $queueId
     * @return void
     */
    public function process(int $queueId): void;

}
