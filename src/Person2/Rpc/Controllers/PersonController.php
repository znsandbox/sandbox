<?php

namespace ZnSandbox\Sandbox\Person2\Rpc\Controllers;

use Symfony\Component\Validator\Constraints\NotBlank;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Helpers\ValidationHelper;
use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;
use ZnLib\Rpc\Domain\Entities\RpcResponseEntity;
use ZnLib\Rpc\Rpc\Base\BaseCrudRpcController;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\PersonServiceInterface;

class PersonController extends BaseCrudRpcController
{

    public function __construct(PersonServiceInterface $personService)
    {
        $this->service = $personService;
    }

    public function persist(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        $params = $requestEntity->getParams();

        $errors = ValidationHelper::validateValue(ArrayHelper::getValue($params, 'code'), [new NotBlank()]);
        if ($errors->count()) {
            $e = new UnprocessibleEntityException();
            foreach ($errors as $errorEntity) {
                $e->add('code', $errorEntity->getMessage());
            }
            throw $e;
        }

        $entity = $this->service->createEntity($params);
        $this->service->persist($entity);
        return $this->serializeResult($entity);
    }
}
