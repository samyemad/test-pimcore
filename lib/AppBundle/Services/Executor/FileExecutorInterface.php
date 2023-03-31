<?php

namespace Imported\AppBundle\Services\Executor;

interface FileExecutorInterface
{
    /**
     * Execute File and get Data from it and then process it to the queue
     * @param string $path
     * @param int $key  key for the element
     * @return string
     */
    public function executeFile(string $path,int $key): string;
    /**
     * Check this file is valid or not based on specific types
     * @param string $path
     * @return bool
     */
    function checkValidFile(string $path): bool;
}
