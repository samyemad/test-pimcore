<?php

namespace Imported\AppBundle;

use Imported\AppBundle\DependencyInjection\ImportedAppExtension;
use Imported\AppBundle\DependencyInjection\CompilerPass\MappingConfigurationPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ImportedAppBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new ImportedAppExtension();
        }

        return $this->extension;
    }

    /**
     * @param ContainerBuilder $container
     * @return void
     */
    public function build(ContainerBuilder $container):void
    {
        $container->addCompilerPass(new MappingConfigurationPass());
    }
}
