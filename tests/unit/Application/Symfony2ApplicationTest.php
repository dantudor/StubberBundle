<?php

use Stubber\Bundle\Application\Symfony2Application;

class Symfony2ApplicationTest extends PHPUnit_Framework_TestCase
{
    public function testGetKernel()
    {
        $server = Mockery::mock('\Stubber\Server');
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

        $server = Mockery::mock('\Stubber\Server');

        $request = Mockery::mock('\React\Http\Request');
        $request->shouldReceive('getPath')->once();

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
            ->setHost($host)
            ->setPort($port)
            ->setKernel($kernel)
            ->handleRequest($request, $response)
        ;
    }
}