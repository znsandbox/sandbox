<?php

namespace ZnSandbox\Sandbox\UserRegistration\Domain\Interfaces\Services;

use ZnSandbox\Sandbox\UserRegistration\Domain\Forms\RegistrationForm;
use ZnSandbox\Sandbox\UserRegistration\Domain\Forms\RequestActivationCodeForm;

interface RegistrationServiceInterface
{

    public function requestActivationCode(RequestActivationCodeForm $requestActivationCodeForm);

    //public function createAccount(RegistrationForm $registrationForm, string $activationCode);
}
