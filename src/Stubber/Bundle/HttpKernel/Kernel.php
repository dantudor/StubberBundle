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
     * @param string  $rootDirectory The root kernel directory
     */
    public function __construct($environment, $debug, $rootDirectory)
    {
        parent::__construct($environment, $debug);
        $this->rootDir = $rootDirectory;
    }
}