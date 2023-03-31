<?php

namespace Imported\AppBundle\Services\Mapping\Data;

use Pimcore\Model\Element\ElementInterface;

class MultiValuesMappingData implements MappingDataInterface
{

    public function process(ElementInterface $element,mixed $data, array $configuration): void
    {
        $functionName="set".ucfirst($configuration['key']);
        if(method_exists($element,$functionName))
        {
            $data=strpos($data,",") ? explode(",", $data) : [$data];
            $element->$functionName($data);
        }
    }

}
