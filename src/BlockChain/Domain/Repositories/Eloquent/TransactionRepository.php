<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Repositories\Eloquent;

use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;
use ZnDatabase\Base\Domain\Mappers\BinaryMapper;
use ZnDatabase\Base\Domain\Mappers\GmpMapper;
use ZnDatabase\Base\Domain\Mappers\JsonMapper;
use ZnDatabase\Base\Domain\Mappers\TimeMapper;
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
//            new BinaryMapper(['signature']),
            new GmpMapper(['digest']),
        ];
    }
}
