<?php

namespace ZnLib\Rpc\Domain\Services;

use ZnLib\Rpc\Domain\Interfaces\Services\VersionHandlerServiceInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnLib\Rpc\Domain\Entities\VersionHandlerEntity;

class VersionHandlerService extends \ZnLib\Rpc\Domain\Services\VersionHandlerService  // BaseCrudService implements VersionHandlerServiceInterface
{

    /*public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return VersionHandlerEntity::class;
    }*/


}

