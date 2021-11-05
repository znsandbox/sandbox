<?php

namespace ZnSandbox\Sandbox\Rpc\Domain\Subscribers;

use ZnSandbox\Sandbox\Rpc\Domain\Enums\RpcEventEnum;
use ZnSandbox\Sandbox\Rpc\Domain\Events\RpcRequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnBundle\User\Domain\Exceptions\UnauthorizedException;
use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnCore\Base\Exceptions\ForbiddenException;
use ZnCore\Domain\Traits\EntityManagerTrait;
use ZnUser\Rbac\Domain\Interfaces\Services\AssignmentServiceInterface;
use ZnUser\Rbac\Domain\Interfaces\Services\ManagerServiceInterface;

class CheckAccessSubscriber extends \ZnLib\Rpc\Domain\Subscribers\CheckAccessSubscriber //implements EventSubscriberInterface
{

//    use EntityManagerTrait;
//
//    private $authService;
//    private $managerService;
//    private $assignmentService;
//
//    public function __construct(
//        ManagerServiceInterface $managerService,
//        AssignmentServiceInterface $assignmentService,
//        AuthServiceInterface $authService
//    )
//    {
//        $this->managerService = $managerService;
//        $this->authService = $authService;
//        $this->assignmentService = $assignmentService;
//    }
//
//    public static function getSubscribedEvents()
//    {
//        return [
//            RpcEventEnum::BEFORE_RUN_ACTION => 'onBeforeRunAction',
//        ];
//    }
//
//    public function onBeforeRunAction(RpcRequestEvent $event)
//    {
//        $requestEntity = $event->getRequestEntity();
//        $methodEntity = $event->getMethodEntity();
//        if ($methodEntity->getPermissionName()) {
//            $this->checkAccess($methodEntity->getPermissionName());
//        }
//    }
//
//    /**
//     * Проверка прав доступа
//     * @param string $permissionName
//     * @throws ForbiddenException
//     */
//    private function checkAccess(string $permissionName)
//    {
//        try {
//            $identity = $this->authService->getIdentity();
//            $roles = $this->assignmentService->getRolesByIdentityId($identity->getId());
////            $roles = $identity->getRoles();
//        } catch (UnauthorizedException $e) {
//            $identityId = null;
//            $roles = ['rGuest'];
//        }
//        $this->managerService->checkAccess($roles, [$permissionName]);
//    }
}
