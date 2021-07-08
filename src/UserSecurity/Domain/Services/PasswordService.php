<?php

namespace ZnSandbox\Sandbox\UserSecurity\Domain\Services;

use ZnSandbox\Sandbox\UserSecurity\Domain\Interfaces\Services\PasswordHistoryServiceInterface;
use App\User\Domain\Enums\UserActionEnum;
use App\User\Domain\Enums\UserActionEventEnum;
use App\User\Domain\Events\UserActionEvent;
use App\User\Domain\Interfaces\Services\PasswordServiceInterface;
use App\User\Domain\Subscribers\SendNotifyAfterUpdatePasswordSubscriber;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use ZnBundle\User\Domain\Interfaces\Repositories\CredentialRepositoryInterface;
use ZnCore\Base\Libs\Event\Traits\EventDispatcherTrait;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Base\BaseService;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;

class PasswordService extends BaseService implements PasswordServiceInterface
{

    use EventDispatcherTrait;

    protected $credentialRepository;
    protected $passwordHistoryService;
    protected $passwordHasher;

    public function __construct(
        EntityManagerInterface $em,
        CredentialRepositoryInterface $credentialRepository,
        PasswordHistoryServiceInterface $passwordHistoryService,
        PasswordHasherInterface $passwordHasher

    )
    {
        $this->setEntityManager($em);
        $this->credentialRepository = $credentialRepository;
        $this->passwordHistoryService = $passwordHistoryService;

        $this->passwordHasher = $passwordHasher;
    }

    public function subscribes(): array
    {
        return [
            SendNotifyAfterUpdatePasswordSubscriber::class,
        ];
    }

    public function setPassword(string $newPassword, int $identityId = null)
    {
        $this->checkNewPasswordExists($newPassword, $identityId);
        $this->setNewPassword($newPassword, $identityId);
        $this->passwordHistoryService->add($newPassword, $identityId);
        $event = new UserActionEvent($identityId, UserActionEnum::UPDATE_PASSWORD);
        $this->getEventDispatcher()->dispatch($event, UserActionEventEnum::AFTER_UPDATE_PASSWORD);
    }

    /**
     * Установить новый пароль во все типы credential
     * @param string $newPassword
     * @param int|null $identityId
     */
    private function setNewPassword(string $newPassword, int $identityId = null)
    {
        $all = $this->credentialRepository->allByIdentityId($identityId, ['login', 'email']);
        $passwordHash = $this->passwordHasher->hash($newPassword);
        foreach ($all as $credentialEntity) {
            $credentialEntity->setValidation($passwordHash);
            $this->getEntityManager()->persist($credentialEntity);
        }
    }

    /**
     * Проверить новый пароль на существование и истории
     * @param string $newPassword
     * @param int|null $identityId
     * @throws UnprocessibleEntityException
     */
    private function checkNewPasswordExists(string $newPassword, int $identityId = null)
    {
        $isHasPassword = $this->passwordHistoryService->isHas($newPassword, $identityId);
        if ($isHasPassword) {
            $exception = new UnprocessibleEntityException();
            $exception->add('newPassword', I18Next::t('user_security', 'change-password.message.password_exists_in_history'));
            throw $exception;
        }
    }
}
