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
        $pub = BitcoinHelper::extractPublicKey($document);
        $fromAddress = BitcoinHelper::extractP2pkhAddressFromPublicKeyHash($pub->getPubKeyHash()->getBinary());

        /*$privFactory = new PrivateKeyFactory();
        $priv = $privFactory->fromWif('L4stU9ZoL9AXmxuerpTRE26Tbq5AQKFrBxT1sgoTAnxHywUumf41');
        $publicKey = $priv->getPublicKey();
        $pubKeyHash = $publicKey->getPubKeyHash();*/

        $ec = Bitcoin::getEcAdapter();
        $signer = new MessageSigner($ec);

        /** @var CompactSignatureSerializerInterface $compactSigSerializer */
        $compactSigSerializer = EcSerializer::getSerializer(CompactSignatureSerializerInterface::class);
        $serializer = new SignedMessageSerializer($compactSigSerializer);

        /*$document11 = '-----BEGIN BITCOIN SIGNED MESSAGE-----
11111111111
-----BEGIN SIGNATURE-----
H68Jiv7qQdQ0Qu2RvKO8QUCbh1Jmq+6YgIGS/8gialBoDtcKF364efb/sx5xKqjx45hqcDuVQIDAn6bYKjf0vFc=
-----END BITCOIN SIGNED MESSAGE-----';*/

        $signedMessage = $serializer->parse($document);

        $addrCreator = new AddressCreator();
        /** @var PayToPubKeyHashAddress $payToPubKeyHashAddress */
        $payToPubKeyHashAddress = $addrCreator->fromString($fromAddress);

//        $pub = null;
//        $pub = $signer->recoverPubKey($signedMessage, $payToPubKeyHashAddress);
        $isVerify = $signer->verify($signedMessage, $payToPubKeyHashAddress);
        if(!$isVerify) {
            throw new \Exception('Signature not verified!');
        }
        return [
            'address' => $fromAddress,
//            'document' => $document,
            'message' => $signedMessage->getMessage(),
            'publicKey' => $pub->getHex(),
            'isVerify' => $isVerify,
        ];
    }
}
