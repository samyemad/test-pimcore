<?php

namespace Imported\AppBundle\Services\Mapping\Data;

use Pimcore\Model\Element\ElementInterface;
use Pimcore\Model\DataObject\Service;

class OneToManyMappingData implements MappingDataInterface
{

    /**
     * @var string
     */
    protected string  $originalProperty;

    public function process(ElementInterface $element,mixed $data, array $configuration): void
    {
        $this->originalProperty = ucfirst($configuration['key']);
        $relationalObject=null;
        if(!empty($configuration['targetClass']) && !empty($configuration['targetProperty'])) {
            $relationalObject = $this->checkAndCreateRelationObject($data, $configuration['targetClass'], $configuration['targetProperty']);
        }
        if($relationalObject != null) {
            $functionName = "set" . $this->originalProperty;
            if (method_exists($element, $functionName)) {
                $element->$functionName($relationalObject);
            }
        }

    }

    /**
     * check the relational Object and create it if not exists
     * @param mixed $data
     * @param string $targetClass
     * @param string $targetProperty
     * @return ElementInterface|null
     */
    private function checkAndCreateRelationObject(mixed $data,string $targetClass,string $targetProperty): ?ElementInterface
    {
        $object= null;
        if(property_exists($targetClass, $targetProperty))
        {
            $targetProperty=ucfirst($targetProperty);
            $targetSelectFunction="getBy".$targetProperty;
            $object = $targetClass::$targetSelectFunction($data,['limit' => 1,'published' => true]);
            if($object == null)
            {
                $object=$this->createRelationObject($data,$targetClass,$targetProperty);
            }
        }
        return $object;
    }

    /**
     * create new relational Object based on data and properties
     * @param mixed $data
     * @param string $targetClass
     * @param string $targetProperty
     * @return ElementInterface
     */
    private function createRelationObject(mixed $data,string $targetClass,string $targetProperty): ElementInterface
    {
        $key=uniqid();
        $targetSetterFunction="set".$targetProperty;
        $object = new $targetClass();
        $object->setParent(Service::createFolderByPath($this->originalProperty));
        $object->setKey($key);
        $object->setPublished(1);
        $object->$targetSetterFunction($data);
        $object->save();
        return $object;
    }
}
