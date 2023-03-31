<?php

namespace Imported\AppBundle\Services\Import\Preparation;

use Imported\AppBundle\Event\ProcessImportEvent;
use Imported\AppBundle\Services\Executor\FileExecutorInterface;
use Imported\AppBundle\Services\Provider\ProviderInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class CsvImportPreparation implements ImportPreparationInterface
{
    /**
     * @var ProviderInterface
     */
    protected ProviderInterface $provider;
    /**
     * @var FileExecutorInterface
     */
    protected FileExecutorInterface $fileExecutor;
    /**
     * @var EventDispatcherInterface
     */
    protected EventDispatcherInterface $eventDispatcher;
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    public function __construct(
        ProviderInterface $assetProvider,
        FileExecutorInterface $csvFileExecutor,
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        $this->provider = $assetProvider;
        $this->fileExecutor = $csvFileExecutor;
        $this->eventDispatcher = $eventDispatcher;
        $this->logger = $logger;
     }
    public function process(array $data): bool
    {
        $success= false;
        try {
            $path=$this->provider->process($data);
            if(!empty($path))
            {
                $groupName= $this->fileExecutor->executeFile($path,$data['id']);
                $this->eventDispatcher->dispatch(new ProcessImportEvent($groupName));
                $success = true;
            }
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
        return $success;
    }
}
