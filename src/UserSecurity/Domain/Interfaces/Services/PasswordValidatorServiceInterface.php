<?php

namespace ZnSandbox\Sandbox\UserSecurity\Domain\Interfaces\Services;

use ZnCore\Domain\Exceptions\UnprocessibleEntityException;

interface PasswordValidatorServiceInterface
{

    /**
     * Валидация пароля
     * @param string $password
     * @throws UnprocessibleEntityException
     */
    public function validate(?string $password): void;
}
