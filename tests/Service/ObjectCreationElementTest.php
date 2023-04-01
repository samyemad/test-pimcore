<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Pimcore\Model\DataObject\Car;
use Pimcore\Model\DataObject\Manufacturer;
use Imported\AppBundle\Services\Creation\ObjectCreationElement;
use Pimcore\Model\Element\ElementInterface;

class ObjectCreationElementTest extends KernelTestCase
{
    public function preparationObjectCreationElement(): array
    {
        return [
            'Creation Car' => ['creationConfig' => ['settings' => ['pathLocationFolder' => '/imported','classType' => Car::class]]],
            'Creation Manufacturer' => ['creationConfig' => ['settings' => ['pathLocationFolder' => '/Manufacturer','classType' => Manufacturer::class]]],
        ];
    }
    /**
     * @dataProvider preparationObjectCreationElement
     * @param array $data
     */
    public function testObjectCreationElement(array $data)
    {
        $objectCreationElement=new ObjectCreationElement($data);
        $createdElement = $objectCreationElement->process();
        $this->assertInstanceOf(ElementInterface::class, $createdElement);
    }

}
