<?php

namespace ZnSandbox\Sandbox\Wsdl\Domain\Repositories\File;

use ZnSandbox\Sandbox\Wsdl\Domain\Entities\ServiceEntity;
use ZnSandbox\Sandbox\Wsdl\Domain\Interfaces\Repositories\ServiceRepositoryInterface;
use ZnCore\Domain\Repository\Base\BaseRepository;

class ServiceRepository extends BaseRepository implements ServiceRepositoryInterface
{

    private $collection;

    public function getEntityClass(): string
    {
        return ServiceEntity::class;
    }

    public function getCollection()
    {
        return $this->collection;
    }

    public function setCollection($collection): void
    {
        $this->collection = $collection;
    }

    public function oneByName(string $appName): ServiceEntity
    {
        $apps = $this->collection;
        if (!array_key_exists($appName, $apps)) {
            throw new \Exception('Application "' . $appName . '" not defined!');
        }
        return $this->getEntityManager()->createEntity($this->getEntityClass(), $apps[$appName]);
    }
}
