<?php

namespace ZnSandbox\Sandbox\BlockChain\Rpc\Controllers;

use Psr\Container\ContainerInterface;
use ZnCore\Base\Libs\Container\ContainerAwareTrait;
use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;
use ZnLib\Rpc\Domain\Entities\RpcResponseEntity;
use ZnLib\Rpc\Rpc\Base\BaseCrudRpcController;
use ZnLib\Socket\Domain\Entities\SocketEventEntity;
use ZnLib\Socket\Domain\Libs\SocketDaemon;
use ZnSandbox\Sandbox\BlockChain\Domain\Helper\BitcoinHelper;

//use ZnSandbox\Sandbox\BlockChain\Domain\Libs\MessageSigner\MessageSigner;

class DocumentController extends BaseCrudRpcController
{

    use ContainerAwareTrait;

    private $socketDaemon;

    /*private $personService;

    public function __construct(
        MyChildServiceInterface $myChildService,
        PersonServiceInterface $personService,
        ContainerInterface $container
    )
    {
        $this->service = $myChildService;
        $this->personService = $personService;
        $this->setContainer($container);
    }*/

    public function __construct(SocketDaemon $socketDaemon)
    {
//        parent::__construct($container);
        $this->socketDaemon = $socketDaemon;
    }

    public function send(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
//        $fromAddress = $requestEntity->getParamItem('fromAddress');
        $document = $requestEntity->getParamItem('document');
        $result = $this->verifyDocument($document);
        return $this->serializeResult($result);
    }

    private function verifyDocument(string $document)
    {
        $documentEntity = BitcoinHelper::verifyDocument($document);

        $data = json_decode($documentEntity->getMessage(), JSON_OBJECT_AS_ARRAY);
        if (json_last_error()) {
            $data = null;
            throw new \Exception('crypto: Bad JSON');
        }
        $data['fromAddress'] = $documentEntity->getPublic()->getAddress();

        /*if ($data['method'] == 'sendMessage') {
            $event = new SocketEventEntity;
            $event->setUserId($data['toAddress']);
            $event->setName('messenger.newMessage');
            $event->setData($data);
            $this->socketDaemon->sendMessageToTcp($event);
        } else*/if ($data['method'] == 'message') {
            $event = new SocketEventEntity;
            $event->setUserId($data['toAddress']);
            // messenger.newMessage
            $event->setName('cryptoMessage.p2p');
            $event->setData($data);
            $this->socketDaemon->sendMessageToTcp($event);
        } else {
            throw new \Exception('crypto: Unknown method');
        }


//        return EntityHelper::toArray($documentEntity);
        return [
            'data' => $data,
//            'document' => $document,
            'message' => $documentEntity->getMessage(),

            'address' => $documentEntity->getPublic()->getAddress(),
            'publicKey' => bin2hex($documentEntity->getPublic()->getPublicKey()),
            'publicHash' => bin2hex($documentEntity->getPublic()->getPublicHash()),
            'isVerify' => true,
        ];
    }
}
