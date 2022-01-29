<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Services;

use ZnSandbox\Sandbox\BlockChain\Domain\Interfaces\Services\TransactionServiceInterface;
use ZnSandbox\Sandbox\BlockChain\Domain\Interfaces\Repositories\TransactionRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\BlockChain\Domain\Entities\TransactionEntity;

/**
 * @method
 * TransactionRepositoryInterface getRepository()
 */
class TransactionService extends BaseCrudService implements TransactionServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return TransactionEntity::class;
    }


}

