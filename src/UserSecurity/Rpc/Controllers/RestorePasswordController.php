<?php

namespace ZnSandbox\Sandbox\UserSecurity\Rpc\Controllers;

use App\User\Domain\Forms\CreatePasswordForm;
use App\User\Domain\Forms\RequestActivationCodeForm;
use App\User\Domain\Interfaces\Services\RestorePasswordServiceInterface;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;
use ZnLib\Rpc\Domain\Entities\RpcResponseEntity;

class RestorePasswordController
{

    private $service;

    public function __construct(RestorePasswordServiceInterface $restorePasswordService)
    {
        $this->service = $restorePasswordService;
    }

    public function requestActivationCode(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        $form = new RequestActivationCodeForm();
        EntityHelper::setAttributes($form, $requestEntity->getParams());
        $this->service->requestActivationCode($form);
        $response = new RpcResponseEntity();
        return $response;
    }

    public function createPassword(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        $form = new CreatePasswordForm();
        EntityHelper::setAttributes($form, $requestEntity->getParams());
        $this->service->createPassword($form);
        $response = new RpcResponseEntity();
        return $response;
    }
}
