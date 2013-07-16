<?php

use Stubber\Bundle\Application\Symfony2Application;

class Symfony2ApplicationTest extends PHPUnit_Framework_TestCase
{
    public function testGetKernel()
    {
        $server = Mockery::mock('\Stubber\Server');
        $server->shouldReceive('setApplication')->andReturn($server);

        $kernel = Mockery::mock('\Stubber\Bundle\HttpKernel\Kernel');

        $application = new Symfony2Application($server);

        $this->assertNull($application->getKernel());
        $this->assertSame($application, $application->setKernel($kernel));
        $this->assertSame($kernel, $application->getKernel());
    }

    public function testHandleRequest()
    {
        $host = '127.0.0.1';
        $port = 8080;
        $responseStatusCode = 200;

        $primedRequest = Mockery::mock('\Stubber\Primer\Request');
        $primedRequest->shouldIgnoreMissing();

        $primer = Mockery::mock('\Stubber\Primer');
        $primer->shouldReceive('isPrimed')->andReturn(true);
        $primer->shouldReceive('getNextPrimedRequest')->andReturn($primedRequest);

        $server = Mockery::mock('\Stubber\Server');
        $server->shouldReceive('setApplication')->andReturn($server);
        $server->shouldReceive('getHost')->once()->andReturn($host);
        $server->shouldReceive('getPort')->once()->andReturn($port);
        $server->shouldReceive('getPrimer')->once()->andReturn($primer);

        $request = Mockery::mock('\React\Http\Request');
        $request->shouldReceive('getPath')->once();
        $request->shouldIgnoreMissing();

        $response = Mockery::mock('\React\Http\Response');
        $response->shouldReceive('writeHead')->once()->with($responseStatusCode, array('Content-Type' => 'text/html'));
        $response->shouldReceive('getContent')->once();
        $response->shouldReceive('end')->once();

        $symfonyResponse = Mockery::mock('\Symfony\HttpFoundation\Response');
        $symfonyResponse->shouldReceive('getStatusCode')->andReturn($responseStatusCode);
        $symfonyResponse->shouldReceive('getContent');

        $kernel = Mockery::mock('\Stubber\Bundle\HttpKernel\Kernel');
        $kernel->shouldReceive('handle')->once()->andReturn($symfonyResponse);

        $application = new Symfony2Application($server);
        $application
            ->setKernel($kernel)
            ->handleRequest($request, $response)
        ;
    }
}