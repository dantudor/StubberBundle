<?php

namespace Stubber\Bundle\Application;

use Stubber\Application\AbstractApplication;
use Stubber\Server;
use React\Http\Request;
use React\Http\Response;
use Stubber\Bundle\HttpKernel\Kernel as StubberKernel;
use Stubber\Bundle\HttpFoundation\Request as StubberRequest;

/**
 * Class Symfony2Application
 *
 * @package Stubber\Bundle\Application
 */
class Symfony2Application extends AbstractApplication
{
    /**
     * @var Kernel
     */
    protected $kernel;

    /**
     * Constructor
     *
     * @param string $host
     * @param int    $port
     * @param Server $server
     * @param StubberKernel $kernel
     */
    public function __construct($host, $port, Server $server, StubberKernel $kernel)
    {
        parent::__construct($host, $port, $server);

        $this->kernel = $kernel;
    }

    /**
     * Get Kernel
     *
     * @return Kernel
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    /**
     * Handle Request
     *
     * @param Request $request
     * @param Response $response
     */
    public function handleRequest(Request $request, Response $response)
    {
        $kernelResponse = $this->kernel->handle(StubberRequest::create(
            'http://' . $this->getHost() . ':' . $this->getPort() . $request->getPath()
        ));
        $response->writeHead($kernelResponse->getStatusCode(), array('Content-Type' => 'text/html'));
        $response->end($kernelResponse->getContent());
    }
}