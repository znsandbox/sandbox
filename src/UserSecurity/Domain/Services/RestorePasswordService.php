<?php

namespace ZnSandbox\Sandbox\UserSecurity\Domain\Services;

use App\User\Domain\Enums\UserNotifyTypeEnum;
use ZnSandbox\Sandbox\UserSecurity\Domain\Enums\UserSecurityNotifyTypeEnum;
use ZnSandbox\Sandbox\UserSecurity\Domain\Forms\CreatePasswordForm;
use ZnSandbox\Sandbox\UserSecurity\Domain\Forms\RequestActivationCodeForm;
use ZnSandbox\Sandbox\UserSecurity\Domain\Interfaces\Services\RestorePasswordServiceInterface;
use ZnBundle\Notify\Domain\Interfaces\Services\EmailServiceInterface;
use ZnBundle\Summary\Domain\Interfaces\Services\AttemptServiceInterface;
use ZnBundle\User\Domain\Entities\ConfirmEntity;
use ZnBundle\User\Domain\Enums\ConfirmActionEnum;
use ZnBundle\User\Domain\Enums\CredentialTypeEnum;
use ZnBundle\User\Domain\Interfaces\Repositories\CredentialRepositoryInterface;
use ZnBundle\User\Domain\Interfaces\Services\ConfirmServiceInterface;
use ZnCore\Base\Enums\Measure\TimeEnum;
use ZnCore\Base\Exceptions\AlreadyExistsException;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Helpers\ValidationHelper;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\NotifyServiceInterface;

class RestorePasswordService implements RestorePasswordServiceInterface
{

    protected $passwordService;
    protected $credentialRepository;
    protected $emailService;
    protected $confirmService;
    private $attemptService;
    private $notifyService;

    public function __construct(
        CredentialRepositoryInterface $credentialRepository,
        PasswordService $passwordService,
        EmailServiceInterface $emailService,
        AttemptServiceInterface $attemptService,
        ConfirmServiceInterface $confirmService,
        NotifyServiceInterface $notifyService
    )
    {
        $this->credentialRepository = $credentialRepository;
        $this->passwordService = $passwordService;
        $this->emailService = $emailService;
        $this->confirmService = $confirmService;
        $this->attemptService = $attemptService;
        $this->notifyService = $notifyService;
    }

    public function requestActivationCode(RequestActivationCodeForm $requestActivationCodeForm)
    {
        ValidationHelper::validateEntity($requestActivationCodeForm);
        try {
            $credentialEntity = $this->credentialRepository->oneByCredential($requestActivationCodeForm->getEmail(), CredentialTypeEnum::EMAIL);
        } catch (NotFoundException $e) {
            $exception = new UnprocessibleEntityException();
            $exception->add('email', I18Next::t('core', 'message.not_found'));
            throw $exception;
        }

        $confirmEntity = new ConfirmEntity;
        $confirmEntity->setLogin($requestActivationCodeForm->getEmail());
        $confirmEntity->setAction(ConfirmActionEnum::RESTORE_PASSWORD);
        $confirmEntity->setExpire(time() + TimeEnum::SECOND_PER_MINUTE * 5);
        try {
            $this->confirmService->add($confirmEntity);
        } catch (AlreadyExistsException $e) {
            $message = I18Next::t('summary', 'attempt.message.attempts_have_been_exhausted_time', ['seconds' => $e->getMessage()]);
            throw new AlreadyExistsException($message);
        }

        $this->notifyService->sendNotifyByTypeName(UserSecurityNotifyTypeEnum::RESTORE_PASSWORD_ACTIVATION_CODE, $credentialEntity->getIdentityId(), [
            'code' => $confirmEntity->getCode(),
        ]);
    }

    public function createPassword(CreatePasswordForm $createPasswordForm)
    {
        ValidationHelper::validateEntity($createPasswordForm);
        $identityId = $this->identityIdByCredential($createPasswordForm->getEmail());
        // верификация кода активации
        $isVerify = $this->confirmService->isVerify($createPasswordForm->getEmail(), ConfirmActionEnum::RESTORE_PASSWORD, $createPasswordForm->getActivationCode());
        if (!$isVerify) {
            $message = I18Next::t('user', 'registration.invalid_activation_code');
            ValidationHelper::throwUnprocessable(['activation_code' => $message]);
        }
        $this->passwordService->setPassword($createPasswordForm->getPassword(), $identityId);
        $this->confirmService->activate($createPasswordForm->getEmail(), ConfirmActionEnum::RESTORE_PASSWORD, $createPasswordForm->getActivationCode());
    }

    /**
     * @param string $credential
     * @return int
     * @throws UnprocessibleEntityException
     */
    private function identityIdByCredential(string $credential): int
    {
        try {
            $credentialEntity = $this->credentialRepository->oneByCredential($credential, CredentialTypeEnum::EMAIL);
            return $credentialEntity->getIdentityId();
        } catch (NotFoundException $e) {
            $exception = new UnprocessibleEntityException();
            $exception->add('email', I18Next::t('core', 'message.not_found'));
            throw $exception;
        }
    }
}
