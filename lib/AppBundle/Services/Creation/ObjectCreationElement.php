<?php

namespace Imported\AppBundle\Services\Creation;

use Pimcore\Model\DataObject\Service;
use Pimcore\Model\Element\ElementInterface;

class ObjectCreationElement implements CreationElementInterface
{
    /**
     * @var array
     */
    protected  array $creationConfig;

    public function __construct(array $creationConfig)
    {
        $this->creationConfig = $creationConfig;
    }
    public function process(): ElementInterface
    {
        $key=uniqid();
        $settings=$this->creationConfig['settings'];
        $classType=$settings['classType'];
        $object = new $classType();
        $object->setParent(Service::createFolderByPath($settings['pathLocationFolder']));
        $object->setKey($key);
        $object->setPublished(true);
        return $object;
    }




}
