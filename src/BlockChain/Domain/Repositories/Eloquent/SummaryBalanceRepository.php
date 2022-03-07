<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Repositories\Eloquent;

use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\BlockChain\Domain\Entities\SummaryBalanceEntity;

class SummaryBalanceRepository extends BaseEloquentCrudRepository
{

    public function tableName() : string
    {
        return 'blockchain_summary_balance';
    }

    public function getEntityClass() : string
    {
        return SummaryBalanceEntity::class;
    }


}

