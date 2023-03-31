<?php

namespace Imported\AppBundle\Services\Import\Preparation;

interface ImportPreparationInterface
{
    /**
     * Prepare the import process and execute the file
     * @param array $data
     * @return bool
     */
    public function process(array $data): bool;

}
