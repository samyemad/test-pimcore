<?php

namespace Imported\AppBundle\Services\Creation;

use Pimcore\Model\Element\ElementInterface;

interface CreationElementInterface
{
    /**
     * Create Item to the specific Data Object and assign parent to it
     * @return ElementInterface
     */
    public function process(): ElementInterface;

}
