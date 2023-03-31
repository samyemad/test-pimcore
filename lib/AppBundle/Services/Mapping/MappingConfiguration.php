<?php

namespace Imported\AppBundle\Services\Mapping;

use Imported\AppBundle\Services\Queue\DbQueueInterface;
use Pimcore\Model\Element\ElementInterface;

class MappingConfiguration implements MappingInterface
{
    /**
     * @var DbQueueInterface
     */
    protected DbQueueInterface $dbQueue;
    /**
     * @var array
     */
    protected array $mappingConfigurationDataClasses;
    /**
     * @var array
     */
    protected array $mappingConfigurations;

    public function __construct(DbQueueInterface $defaultDbQueue,array $mappingConfigurations,array $mappingConfigurationDataClasses)
    {
        $this->dbQueue = $defaultDbQueue;
        $this->mappingConfigurationDataClasses = $mappingConfigurationDataClasses;
        $this->mappingConfigurations = $mappingConfigurations;
    }

    public function process(ElementInterface $element,array $data) :void
    {
        foreach($this->mappingConfigurations as $key => $mappingConfiguration)
        {
            $type=$mappingConfiguration['type'];
            if(array_key_exists($type,$this->mappingConfigurationDataClasses))
            {
                $dataTarget=$this->prepareDateBasedOnSource($mappingConfiguration['dataSourceIndex'],$data);
                $mappingConfiguration['key'] = $key;
                $this->mappingConfigurationDataClasses[$type]->process($element,$dataTarget,$mappingConfiguration);
            }

        }
        $element->save();
    }
    /**
     * prepare the data based on the source index in the file
     * @param mixed $dataSourceIndex
     * @param array $data
     * @return mixed
     */
    private function prepareDateBasedOnSource(mixed $dataSourceIndex,array $data): mixed
    {
        if (is_array($dataSourceIndex))
        {
            $result = [];
            foreach ($dataSourceIndex as $index) {
                $result[] = $data[$index] ?? null;
            }
            if (count($data) === 1) {
                $result = $data[0];
            }
        } else {
            $result = $data[$dataSourceIndex] ?? null;
        }
        return $result;
    }
}
