<?php

namespace Stubber\Bundle\Application;

use Stubber\Application\AbstractApplication;
use React\Http\Request;
use React\Http\Response;
use Stubber\Bundle\HttpKernel\Kernel as SymfonyKernel;
use Stubber\Bundle\HttpFoundation\Request as SymfonyRequest;
use Stubber\Exception\PrimerException;

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
     * Set Kernel
     *
     * @param SymfonyKernel $kernel
     *
     * @return $this
     */
    public function setKernel(SymfonyKernel $kernel)
    {
        $this->kernel = $kernel;

        return $this;
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
        try {
            $expectedRequest = $this->getExpectedRequest();
            if (true === $this->validateRequest($expectedRequest, $request)) {
                $kernelResponse = $this->kernel->handle(SymfonyRequest::create(
                    'http://' . $this->getServer()->getHost() . ':' . $this->getServer()->getPort() . $request->getPath()
                ));
                $response->writeHead($kernelResponse->getStatusCode(), $expectedRequest->getResponseOption('Content-Type')->getOrElse('text/html'));
                $response->end($kernelResponse->getContent());
            }
        } catch(PrimerException $e) {
            $response->writeHead(418, array('Content-Type' => 'text/html'));
            $response->end('Stubber not primed for this request.');
        }
    }
}