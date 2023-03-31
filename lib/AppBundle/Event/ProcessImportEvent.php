<?php

namespace Imported\AppBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

class ProcessImportEvent extends Event
{
    private string $groupName;

    public function __construct(string $groupName)
    {
        $this->groupName = $groupName;
    }

    /**
     * @return string
     */
    public function getGroupName(): string
    {
        return $this->groupName;
    }
}
