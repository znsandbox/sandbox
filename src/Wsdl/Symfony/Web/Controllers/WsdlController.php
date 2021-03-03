<?php

namespace ZnSandbox\Sandbox\Wsdl\Symfony\Web\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ZnSandbox\Sandbox\Wsdl\Symfony\Wsdl\Controllers\TestController;

class WsdlController
{

    private $procedureService;
    private $logger;
    private $responseFormatter;
    private $rpcJsonResponse;
    private $services = [];
    private $wsdlFileName = __DIR__ . '/../config/wsdl';

    public function __construct()
    {
        $this->services['hello'] = new TestController();
    }

    public function showDocs(Request $request): Response
    {
        $docContent = file_get_contents($this->getDefinitionFile());
        $response = new Response($docContent);
        $response->headers->set('Content-Type', 'text/xml');
        return $response;
    }

    private function getDefinitionFile()
    {
        return __DIR__ . '/../../Wsdl/config/hello.wsdl';
    }

    public function callProcedure(Request $request): Response
    {
        $soapServer = new \SoapServer($this->getDefinitionFile());
        foreach ($this->services as $service) {
            $soapServer->setObject($service);
        }
        ob_start();
        $soapServer->handle();
        $content = ob_get_clean();
        $response = new Response;
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');
        $response->setContent($content);
        return $response;
    }
}
