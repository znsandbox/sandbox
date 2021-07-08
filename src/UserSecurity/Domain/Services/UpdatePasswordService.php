<?php

namespace ZnSandbox\Sandbox\UserSecurity\Domain\Services;

use ZnSandbox\Sandbox\UserSecurity\Domain\Forms\UpdatePasswordForm;
use ZnSandbox\Sandbox\UserSecurity\Domain\Interfaces\Services\PasswordServiceInterface;
use ZnSandbox\Sandbox\UserSecurity\Domain\Interfaces\Services\UpdatePasswordServiceInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use ZnBundle\User\Domain\Exceptions\UnauthorizedException;
use ZnBundle\User\Domain\Interfaces\Repositories\CredentialRepositoryInterface;
use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Helpers\ValidationHelper;

class UpdatePasswordService implements UpdatePasswordServiceInterface
{

    protected $authService;
    protected $passwordService;
    protected $credentialRepository;
    protected $passwordHasher;

    public function __construct(
        CredentialRepositoryInterface $credentialRepository,
        PasswordHasherInterface $passwordHasher,
        AuthServiceInterface $authService,
        PasswordServiceInterface $passwordService
    )
    {
        $this->credentialRepository = $credentialRepository;
        $this->passwordHasher = $passwordHasher;
        $this->authService = $authService;
        $this->passwordService = $passwordService;
    }

    public function update(UpdatePasswordForm $updatePasswordForm)
    {
        ValidationHelper::validateEntity($updatePasswordForm);
        $this->checkCurrentPassword($updatePasswordForm->getCurrentPassword());
        $identity = $this->authService->getIdentity();
        $this->passwordService->setPassword($updatePasswordForm->getNewPassword(), $identity->getId());
    }

    /**
     * Проверить старый пароль
     * @param string $currentPassword
     * @throws UnprocessibleEntityException
     * @throws UnauthorizedException
     */
    private function checkCurrentPassword(string $currentPassword)
    {
        $identity = $this->authService->getIdentity();
        $all = $this->credentialRepository->allByIdentityId($identity->getId(), ['login', 'email']);
        $entity = $all->first();
        $isValidCurrentPassword = $this->passwordHasher->verify($entity->getValidation(), $currentPassword);
        if (!$isValidCurrentPassword) {
            $exception = new UnprocessibleEntityException();
            $exception->add('currentPassword', I18Next::t('user_security', 'change-password.message.does_not_match_the_current_password'));
            throw $exception;
        }
    }
}
