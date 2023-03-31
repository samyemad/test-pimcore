<?php

namespace Imported\AppBundle\Services\Provider;

use Exception;

interface ProviderInterface
{
    /**
     * process the provider based on the provided data and get the path
     * @param array $data
     * @return string
     * @throws Exception
     */
    public function process(array $data): string;

    /**
     * set data to internal data properties
     * @param array $data
     * @return void
     * @throws Exception
     */
    public function setDataProperties(array $data): void;
}
