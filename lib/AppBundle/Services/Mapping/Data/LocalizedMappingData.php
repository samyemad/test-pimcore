<?php

namespace Imported\AppBundle\Services\Mapping\Data;

use Pimcore\Model\Element\ElementInterface;
use Pimcore\Tool;

class LocalizedMappingData implements MappingDataInterface
{
    public function process(ElementInterface $element,mixed $data, array $configuration): void
    {
        $setter="set".ucfirst($configuration['key']);
        if(is_array($data))
        {
            $languages = Tool::getValidLanguages();
            if(!empty($languages))
            {
                foreach ($languages as $key => $language)
                {
                    $element->$setter($data[$key], $language);
                }
            }
        }
        else
        {
            $language = Tool::getDefaultLanguage();
            $element->$setter($data, $language);
        }
    }
}
