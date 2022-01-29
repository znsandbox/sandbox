<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnLib\Db\Mappers\BinaryMapper;
use ZnLib\Db\Mappers\GmpMapper;
use ZnLib\Db\Mappers\JsonMapper;
use ZnLib\Db\Mappers\TimeMapper;
use ZnSandbox\Sandbox\BlockChain\Domain\Entities\TransactionEntity;

class TransactionRepository extends BaseEloquentCrudRepository
{

    public function tableName(): string
    {
        return 'blockchain_transaction';
    }

    public function getEntityClass(): string
    {
        return TransactionEntity::class;
    }

    public function mappers(): array
    {
        return [
//            new TimeMapper(['created_at']),
            new JsonMapper(['payload']),
            new BinaryMapper(['signature']),
            new GmpMapper(['digest']),
        ];
    }
}
