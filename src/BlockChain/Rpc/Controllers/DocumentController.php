<?php

namespace ZnSandbox\Sandbox\BlockChain\Rpc\Controllers;

use BitWasp\Bitcoin\Address\AddressCreator;
use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\EcAdapter\EcSerializer;
use BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Signature\CompactSignatureSerializerInterface;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\MessageSigner\MessageSigner;
use BitWasp\Bitcoin\Serializer\MessageSigner\SignedMessageSerializer;
use Psr\Container\ContainerInterface;
use ZnCore\Base\Libs\Container\ContainerAwareTrait;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Libs\Query;
use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;
use ZnLib\Rpc\Domain\Entities\RpcResponseEntity;
use ZnLib\Rpc\Rpc\Base\BaseCrudRpcController;
use ZnLib\Rpc\Rpc\Serializers\SerializerInterface;
use ZnSandbox\Sandbox\BlockChain\Domain\Helper\BitcoinHelper;
//use ZnSandbox\Sandbox\BlockChain\Domain\Libs\MessageSigner\MessageSigner;
use ZnSandbox\Sandbox\Person2\Domain\Entities\InheritanceEntity;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyChildServiceInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\PersonServiceInterface;
use ZnSandbox\Sandbox\Person2\Rpc\Serializers\MyChildSerializer;

class DocumentController extends BaseCrudRpcController
{

    use ContainerAwareTrait;

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

    public function send(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
//        $fromAddress = $requestEntity->getParamItem('fromAddress');
        $document = $requestEntity->getParamItem('document');
        $result = $this->verifyDocument($document);
        return $this->serializeResult($result);
    }

    private function verifyDocument(string $document) {
        $documentEntity = BitcoinHelper::verifyDocument($document);

        $data = json_decode($documentEntity->getMessage(), JSON_OBJECT_AS_ARRAY);
        if(json_last_error()) {
            $data = null;
            throw new \Exception('crypto: Bad JSON');
        }

        if($data['method'] == 'sendMessage') {

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
