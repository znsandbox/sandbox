<?php

namespace ZnSandbox\Sandbox\UserSecurity\Domain\Interfaces\Services;

use ZnSandbox\Sandbox\UserSecurity\Domain\Forms\CreatePasswordForm;
use ZnSandbox\Sandbox\UserSecurity\Domain\Forms\RequestActivationCodeForm;
use ZnCore\Base\Exceptions\AlreadyExistsException;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;

interface RestorePasswordServiceInterface
{

    /**
     * @param RequestActivationCodeForm $requestActivationCodeForm
     * @throws AlreadyExistsException
     * @throws UnprocessibleEntityException
     */
    public function requestActivationCode(RequestActivationCodeForm $requestActivationCodeForm);

    /**
     * @param CreatePasswordForm $createPasswordForm
     * @throws UnprocessibleEntityException
     * @throws NotFoundException
     */
    public function createPassword(CreatePasswordForm $createPasswordForm);

}
