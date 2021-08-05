<?php

namespace ZnSandbox\Sandbox\Geo\Domain\Services;

use ZnSandbox\Sandbox\Geo\Domain\Entities\RegionEntity;
use ZnSandbox\Sandbox\Geo\Domain\Interfaces\Services\RegionServiceInterface;
use ZnSandbox\Sandbox\Geo\Domain\Subscribers\AssignCountryIdSubscriber;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;

/**
 * @method
 * RegionRepositoryInterface getRepository()
 */
class RegionService extends BaseCrudService implements RegionServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return RegionEntity::class;
    }

    public function subscribes(): array
    {
        return [
            AssignCountryIdSubscriber::class,
        ];
    }

}

