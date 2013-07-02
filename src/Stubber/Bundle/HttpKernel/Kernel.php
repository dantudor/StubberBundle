<?php

namespace Stubber\Bundle\HttpKernel;

use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * Class Kernel
 *
 * @package Stubber\Bundle\HttpKernel
 */
abstract class Kernel extends BaseKernel
{
    /**
     * Constructor
     *
     * @param string  $environment   The environment
     * @param Boolean $debug         Whether to enable debugging or not
     */
    public function __construct($environment, $debug)
    {
        parent::__construct($environment, $debug);
    }

    /**
     * Set Root Directory
     *
     * @param $rootDirectory
     *
     * @return Kernel
     */
    public function setRootDirectory($rootDirectory)
    {
        $this->rootDir = $rootDirectory;

        return $this;
    }
}