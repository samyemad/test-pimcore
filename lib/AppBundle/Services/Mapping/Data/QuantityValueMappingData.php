<?php

namespace Imported\AppBundle\Services\Mapping\Data;

use Pimcore\Model\Element\ElementInterface;
use Pimcore\Model\DataObject\QuantityValue\Unit;
use Pimcore\Model\DataObject\Data\QuantityValue;

class QuantityValueMappingData implements MappingDataInterface
{

    public function process(ElementInterface $element,mixed $data, array $configuration): void
    {
        $functionName="set".ucfirst($configuration['key']);
        $data=strpos($data," ") ? explode(" ", $data) : $data;
        if(is_array($data))
        {
            $unit=Unit::getByAbbreviation($data[1]);
           if($unit != null)
           {
               $element->$functionName(new QuantityValue($data[0], $unit->getId()));
           }
        }
        else
        {
            $element->$functionName(new QuantityValue($data));
        }
    }


}
