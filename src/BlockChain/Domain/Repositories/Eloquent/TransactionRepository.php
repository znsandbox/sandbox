<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\BlockChain\Domain\Entities\TransactionEntity;

class TransactionRepository extends BaseEloquentCrudRepository
{

    public function tableName() : string
    {
        return 'blockchain_transaction';
    }

    public function getEntityClass() : string
    {
        return TransactionEntity::class;
    }


}

