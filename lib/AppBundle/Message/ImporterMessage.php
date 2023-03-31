<?php

namespace Imported\AppBundle\Message;

final class ImporterMessage
{
    /**
     * @var array
     */
    protected array $ids;

    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }
    /**
     * get Queue Ids to process it
     * @return array
     */
    public function getIds(): array
    {
        return $this->ids;
    }
}
