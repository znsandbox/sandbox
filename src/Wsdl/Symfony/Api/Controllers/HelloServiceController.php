<?php

namespace PhpLab\Sandbox\Wsdl\Symfony\Api\Controllers;

use PhpLab\Core\Enums\Http\HttpHeaderEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use PHP2WSDL\PHPClass2WSDL;

class HelloServiceController extends AbstractController
{

    private $services = [];
    private $wsdlFileName = __DIR__ . '/../config/wsdl';

    public function __construct()
    {
        $this->services['hello'] = new HelloService;
    }

    private function generateWsdlFromService(string $name): string {
        $content = file_get_contents($this->getDefinitionFileName($name));
        return $content;
    }

    public function definition(string $name)
    {
        $response = new Response;
        $response->headers->set(HttpHeaderEnum::CONTENT_TYPE, 'text/xml');
        $content = $this->generateWsdlFromService($name);
        $response->setContent($content);
        return $response;
    }

    public function handle(string $name)
    {
        $soapServer = new \SoapServer($this->getDefinitionFileName($name));
        $serviceInstance = $this->services[$name];
        $soapServer->setObject($serviceInstance);
        ob_start();
        $soapServer->handle();
        $content = ob_get_clean();
        $response = new Response;
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');
        $response->setContent($content);
        return $response;
    }

    public function test()
    {
        /** @var HelloInterface $helloService */
        $helloService = new \SoapClient('http://symfony.tpl/wsdl/definition/hello.wsdl');
        //dd($helloService->__getFunctions());
        $helloResult = $helloService->hello('Scott');
        $method1Result = $helloService->method1('foo');
        dd([$helloResult, $method1Result]);
    }

    private function getDefinitionFileName(string $serviceName) {
        return $this->wsdlFileName . '/' . $serviceName . '.wsdl';
    }

}

class HelloEntity {

    public $message;

}

interface HelloInterface {
    public function hello(string $name): array;
    public function method1(string $name): string;
}

class HelloService implements HelloInterface
{
    public function hello(string $name): array
    {
        return [
            'Hello, ' . $name,
            'WTF???',
        ];
    }

    public function method1(string $name): string
    {
        return 'method1, ' . $name;
    }
}
