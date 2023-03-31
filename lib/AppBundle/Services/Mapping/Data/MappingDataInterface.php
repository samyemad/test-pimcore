<?php

namespace Imported\AppBundle\Services\Mapping\Data;

use Pimcore\Model\Element\ElementInterface;

interface MappingDataInterface
{
    /**
     * map the data to the element property  based on the mapping type
     * @param ElementInterface $element
     * @param mixed $data
     * @param array $configuration
     * @return void
     */
    public function process(ElementInterface $element,mixed $data,array $configuration): void;
}
