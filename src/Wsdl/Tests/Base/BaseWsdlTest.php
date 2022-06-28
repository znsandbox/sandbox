<?php

namespace ZnSandbox\Sandbox\Wsdl\Tests\Base;

use ZnSandbox\Sandbox\Wsdl\Domain\Libs\SoapClient;
use PHPUnit\Framework\TestCase;
use ZnLib\Components\Format\Encoders\XmlEncoder;
use ZnCore\Base\FileSystem\Helpers\FileStorageHelper;
use ZnTool\Test\Helpers\TestHelper;
use ZnTool\Test\Traits\BaseUrlTrait;
use ZnTool\Test\Traits\FixtureTrait;

abstract class BaseWsdlTest extends TestCase
{

    use BaseUrlTrait;
    use FixtureTrait;

    protected function runRequestFromDir(string $directory)
    {
        $xmlRequest = FileStorageHelper::load($directory . '/request.xml');
        $xmlResponse = $this->sendSoapRequest($xmlRequest);
        $this->assertXmlData($xmlResponse, $directory . '/response.xml');
    }

    protected function assertXmlData(string $actual, string $xmlFileName, bool $rewrite = true)
    {
        $xmlEncoder = new XmlEncoder();
        $actual = $xmlEncoder->c14nify($actual);
        $actual = $xmlEncoder->prettify($actual);

        $expected = FileStorageHelper::load($xmlFileName);
        $expected = $xmlEncoder->c14nify($expected);
        $expected = $xmlEncoder->prettify($expected);



        if ($expected !== $actual && TestHelper::isRewriteData() && $rewrite) {
            FileStorageHelper::save($xmlFileName, $actual);
        }

//        dd($expected, $actual);

        $this->assertEquals($expected, $actual);
    }

    protected function getSoapClient(): SoapClient
    {
        $client = new SoapClient();
//        $client->setBaseUrl($this->getWsdlRequestUrl());
        $client->setRequestUrl($this->getWsdlRequestUrl());
        $client->setDefinitionUrl($this->getWsdlDefinitionUrl());
        $client->setBaseDefinitionUrl($this->getBaseWsdlDefinitionUrl());
        return $client;
    }

    abstract protected function getBaseWsdlDefinitionUrl(): string;

    abstract protected function getWsdlDefinitionUrl(): string;

    abstract protected function getWsdlRequestUrl(): string;

    protected function sendSoapRequest(string $xmlRequest): string
    {
        return $this->getSoapClient()->sendRequest($xmlRequest);
    }
}
