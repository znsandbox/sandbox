<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Repositories\File;

use ZnSandbox\Sandbox\Casbin\Domain\Entities\InheritanceEntity;
use ZnSandbox\Sandbox\Casbin\Domain\Factories\EnforcerFactory;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Repositories\ManagerRepositoryInterface;
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
