<?php

namespace ZnSandbox\Sandbox\Bundle\Domain\Repositories\File;

use Illuminate\Support\Collection;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Base\Helpers\ClassHelper;
use ZnCore\Base\Helpers\InstanceHelper;
use ZnCore\Base\Libs\App\Interfaces\ConfigManagerInterface;
use ZnCore\Domain\Interfaces\DomainInterface;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\Bundle\Domain\Entities\BundleEntity;
use ZnSandbox\Sandbox\Bundle\Domain\Entities\DomainEntity;
use ZnSandbox\Sandbox\Bundle\Domain\Interfaces\Repositories\BundleRepositoryInterface;

class BundleRepository implements BundleRepositoryInterface
{

    private $configManager;

    public function __construct(ConfigManagerInterface $configManager)
    {
        $this->configManager = $configManager;
    }

    public function tableName(): string
    {
        return 'bundle_bundle';
    }

    public function getEntityClass(): string
    {
        return BundleEntity::class;
    }


    public function create(EntityIdInterface $entity)
    {
        // TODO: Implement create() method.
    }

    public function update(EntityIdInterface $entity)
    {
        // TODO: Implement update() method.
    }

    public function deleteById($id)
    {
        // TODO: Implement deleteById() method.
    }

    public function deleteByCondition(array $condition)
    {
        // TODO: Implement deleteByCondition() method.
    }

    public function all(Query $query = null)
    {
        $bundleInstanceArray = $this->configManager->get('bundles');
        $bundleCollection = new Collection();

        foreach ($bundleInstanceArray as $bundleInstance) {
            $bundleClass = get_class($bundleInstance);
            $bundleNamespace = ClassHelper::getNamespace($bundleClass);
            $domainEntity = $this->getDomain($bundleNamespace);

            if(method_exists($bundleInstance, 'getName')) {
                $bundleName = $bundleInstance->getName();
            } elseif($domainEntity !== null) {
                $bundleName = $domainEntity->getName();
            }
            $bundleEntity = new BundleEntity();
            $bundleEntity->setClassName($bundleClass);
            if(isset($bundleName)) {
                $bundleEntity->setName($bundleName);
            }
            $bundleEntity->setNamespace($bundleNamespace);
            $bundleEntity->setDomain($domainEntity);
            $bundleCollection->add($bundleEntity);
        }
        return $bundleCollection;
    }

    private function extractBundleName() {

    }

    private function getDomain(string $bundleNamespace): ?DomainEntity
    {
        $domainNamespace = $bundleNamespace . '\\Domain';
        $domainClass = $bundleNamespace . '\\Domain\\Domain';
        if (class_exists($domainClass)) {
            /** @var DomainInterface $domainInstance */
            $domainInstance = InstanceHelper::create($domainClass);
            $domainName = $domainInstance->getName();
            $domainEntity = new DomainEntity();
            $domainEntity->setClassName($domainClass);
            $domainEntity->setName($domainName);
            $domainEntity->setNamespace($domainNamespace);
            return $domainEntity;
        }
        return null;
    }

    public function count(Query $query = null): int
    {
        // TODO: Implement count() method.
    }

    public function oneById($id, Query $query = null): EntityIdInterface
    {
        $collection = $this->all();
        foreach ($collection as $bundleEntity) {
            if($bundleEntity->getId() == $id) {
                return $bundleEntity;
            }
        }
        throw new NotFoundException();
    }

    /*public function _relations()
    {
        // TODO: Implement relations() method.
    }*/
}

