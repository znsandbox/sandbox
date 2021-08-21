<?php

namespace ZnSandbox\Sandbox\UserRegistration\Rpc\Controllers;

use ZnSandbox\Sandbox\UserRegistration\Domain\Forms\CreateAccountForm;
use ZnSandbox\Sandbox\UserRegistration\Domain\Forms\RequestActivationCodeForm;
use ZnSandbox\Sandbox\UserRegistration\Domain\Interfaces\Services\RegistrationServiceInterface;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;
use ZnLib\Rpc\Domain\Entities\RpcResponseEntity;
use ZnLib\Rpc\Rpc\Base\BaseRpcController;

class RegistrationController extends BaseRpcController
{

    public function __construct(RegistrationServiceInterface $service)
    {
        $this->service = $service;
    }

    public function requestActivationCode(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        $form = new RequestActivationCodeForm();
        EntityHelper::setAttributes($form, $requestEntity->getParams());
        $this->service->requestActivationCode($form);
        return new RpcResponseEntity();
    }

    public function createAccount(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        $createAccountForm = new CreateAccountForm();
        EntityHelper::setAttributes($createAccountForm, $requestEntity->getParams());
        $this->service->createAccount($createAccountForm);
        return new RpcResponseEntity();
    }
}