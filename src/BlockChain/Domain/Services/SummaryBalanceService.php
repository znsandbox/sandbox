<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Services;

use ZnSandbox\Sandbox\BlockChain\Domain\Interfaces\Services\SummaryBalanceServiceInterface;
use ZnSandbox\Sandbox\BlockChain\Domain\Interfaces\Repositories\SummaryBalanceRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\BlockChain\Domain\Entities\SummaryBalanceEntity;

/**
 * @method
 * SummaryBalanceRepositoryInterface getRepository()
 */
class SummaryBalanceService extends BaseCrudService implements SummaryBalanceServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return SummaryBalanceEntity::class;
    }


}

