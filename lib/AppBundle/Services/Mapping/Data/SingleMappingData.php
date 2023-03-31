<?php

namespace Imported\AppBundle\Services\Mapping\Data;

use Pimcore\Model\Element\ElementInterface;

class SingleMappingData implements MappingDataInterface
{

    public function process(ElementInterface $element,mixed $data, array $configuration): void
    {
        $functionName="set".ucfirst($configuration['key']);
        if(method_exists($element,$functionName))
        {
            $data=is_array($data) ? implode(",",$data) : $data;
            $element->$functionName($data);
        }
    }
}
