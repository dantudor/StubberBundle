<?php

use Stubber\Bundle\HttpKernel\Kernel as StubberKernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class KernelTest extends PHPUnit_Framework_TestCase
{
    public function testGetRootDirectory()
    {
        $environment = 'test';
        $debug = true;
        $rootDirectory = 'mfs://mock/root/directory';

        $kernel = new TestKernel($environment, $debug, $rootDirectory);

        $this->assertSame($rootDirectory, $kernel->getRootDir());
    }
}

class TestKernel extends StubberKernel
{
    public function registerBundles()
    {

    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {

    }
}