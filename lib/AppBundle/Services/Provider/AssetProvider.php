<?php

namespace Imported\AppBundle\Services\Provider;

use Exception;
use Imported\AppBundle\Services\Queue\DbQueueInterface;
use Pimcore\Model\Asset;

class AssetProvider implements ProviderInterface
{
    const GROUP_KEY="Asset-";
    /**
     * @var integer
     */
    protected int $assetId;
    /**
     * @var DbQueueInterface
     */
    protected DbQueueInterface $dbQueue;

    public function __construct(DbQueueInterface $defaultDbQueue)
    {
        $this->dbQueue = $defaultDbQueue;
    }

    public function process(array $data): string
    {
        $this->setDataProperties($data);

        $asset = Asset::getById($this->assetId);
        if (empty($asset)) {
            throw new Exception("Asset {$this->assetId} not found.");
        }
        return $this->getUriFromStream($asset->getStream());
    }

    public function setDataProperties(array $data): void
    {
        if (empty($data['id'])) {
            throw new Exception("Asset {$this->assetId} not found.");
        }
        $this->assetId = $data['id'];
        $this->checkAssetInQueue();
    }

    /**
     * check the asset and the items of this asset already in the queue or not
     * @return void
     * @throws Exception
     */
    private function checkAssetInQueue() :void
    {
        $groupName=self::GROUP_KEY.$this->assetId;
        $countItems= $this->dbQueue->getQueueItemCountByGroup($groupName);
        if($countItems > 0)
        {
            throw new Exception("Items of this Asset: {$this->assetId} already placed in the queue.");
        }
    }

    /**
     * Get local file path based on the stream
     * @param resource $stream
     * @return string
     */
    private function getUriFromStream($stream): string
    {
        $uri='';
        if (is_resource($stream))
        {
            $streamMeta = stream_get_meta_data($stream);
            $uri = $streamMeta['uri'];
        }
        return $uri;
    }
}
