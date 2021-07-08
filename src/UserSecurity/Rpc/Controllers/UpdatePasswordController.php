<?php

namespace ZnSandbox\Sandbox\UserSecurity\Rpc\Controllers;

use App\User\Domain\Forms\UpdatePasswordForm;
use App\User\Domain\Interfaces\Services\UpdatePasswordServiceInterface;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;
use ZnLib\Rpc\Domain\Entities\RpcResponseEntity;

class UpdatePasswordController
{

    private $service;

    public function __construct(UpdatePasswordServiceInterface $updatePasswordService)
    {
        $this->service = $updatePasswordService;
    }

    public function update(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        $form = new UpdatePasswordForm();
        EntityHelper::setAttributes($form, $requestEntity->getParams());
        $this->service->update($form);
        $response = new RpcResponseEntity();
        return $response;
    }
}
