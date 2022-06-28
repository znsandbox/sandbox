<?php

namespace ZnSandbox\Sandbox\Wsdl\Domain\Repositories\Wsdl;

use ZnSandbox\Sandbox\Wsdl\Domain\Entities\TransportEntity;
use ZnSandbox\Sandbox\Wsdl\Domain\Enums\StatusEnum;
use ZnSandbox\Sandbox\Wsdl\Domain\Interfaces\Repositories\ClientRepositoryInterface;
use ZnSandbox\Sandbox\Wsdl\Domain\Libs\SoapClient;
use ZnCore\Domain\Repository\Base\BaseRepository;

class ClientRepository extends BaseRepository implements ClientRepositoryInterface
{

    public function send(TransportEntity $transportEntity): void
    {
        $xmlRequest = $transportEntity->getRequest();
        $url = $transportEntity->getUrl();
        $client = new SoapClient();
        $responseXml = $client->sendXmlRequest($xmlRequest, $url);
        $transportEntity->setResponse($responseXml);
//        $transportEntity->setStatusId(StatusEnum::COMPLETE);
    }
}
