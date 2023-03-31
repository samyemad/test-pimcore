<?php

namespace Imported\AppBundle\Services\Mapping;

use Exception;
use Pimcore\Model\Element\ElementInterface;

interface MappingInterface
{
    /**
     * process every item in data based on mapping configuration type and map it to the mapping class data
     * @param ElementInterface $element
     * @param array $data
     * @return void
     * @throws Exception
     */
    public function process(ElementInterface $element,array $data): void;
}
