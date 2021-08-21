<?php

namespace ZnUser\Rbac\Domain\Repositories\File;

use ZnUser\Rbac\Domain\Entities\InheritanceEntity;
use ZnUser\Rbac\Domain\Factories\EnforcerFactory;
use ZnUser\Rbac\Domain\Interfaces\Repositories\ManagerRepositoryInterface;
use Casbin\ManagementEnforcer;
use Symfony\Component\Cache\Adapter\AbstractAdapter;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Contracts\Cache\ItemInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Traits\EntityManagerTrait;

class ManagerRepository implements ManagerRepositoryInterface
{

    use EntityManagerTrait;

    private $cache;

    public function __construct(EntityManagerInterface $em, AdapterInterface $cache)
    {
        $this->setEntityManager($em);
        $this->cache = $cache;
    }

    public function getEnforcer(): ManagementEnforcer
    {
        /** @var ItemInterface $item */
        $item = $this->cache->getItem('rbac.enforcer');
        $serializedRoleManager = $item->get();
        $enforcerFactory = new EnforcerFactory;
        if (empty($serializedRoleManager)) {
            $enforcer = $this->forgeRoleManager();
            $serializedRoleManager = serialize($enforcer->getRoleManager());
            $item->set($serializedRoleManager);
            $this->cache->save($item);
        } else {
            $roleManager = unserialize($serializedRoleManager);
            $enforcer = $enforcerFactory->createEnforcerByRoleManager($roleManager);
        }
        return $enforcer;
    }

    private function forgeRoleManager(): ManagementEnforcer
    {
        $enforcerFactory = new EnforcerFactory;
        $inheritanceCollection = $this->getEntityManager()->all(InheritanceEntity::class);
        return $enforcerFactory->createEnforcerByInheritanceCollection($inheritanceCollection);
    }
}
