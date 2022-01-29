<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Services;

use ZnSandbox\Sandbox\BlockChain\Domain\Interfaces\Services\AddressServiceInterface;
use ZnSandbox\Sandbox\BlockChain\Domain\Interfaces\Repositories\AddressRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\BlockChain\Domain\Entities\AddressEntity;

/**
 * @method
 * AddressRepositoryInterface getRepository()
 */
class AddressService extends BaseCrudService implements AddressServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return AddressEntity::class;
    }


}

