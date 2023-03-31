<?php

namespace Imported\AppBundle\EventListener;

use Pimcore\Event\BundleManager\PathsEvent;

class AdminImportedListener
{

    /**
     * add Js Files when start up the application
     * @param PathsEvent $event
     * @return void
     */
    public function addJSFiles(PathsEvent $event):void
    {
        $event->setPaths(
            array_merge(
                $event->getPaths(),
                [
                    '/bundles/importedapp/admin/js/startup.js'
                ]
            )
        );
    }
}
