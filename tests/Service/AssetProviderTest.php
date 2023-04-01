<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Imported\AppBundle\Services\Provider\AssetProvider;
use Exception;

class AssetProviderTest extends KernelTestCase
{
    public function testAssetProvider()
    {
        $this->expectException(Exception::class);
        $kernel = \Pimcore\Bootstrap::kernel();
        $assetProvider = $kernel->getContainer()->get(AssetProvider::class);
        $data=['id' => 9999];
        $assetProvider->process($data);
    }
}
