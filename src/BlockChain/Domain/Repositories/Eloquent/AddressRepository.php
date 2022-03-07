<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Repositories\Eloquent;

use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\BlockChain\Domain\Entities\AddressEntity;

class AddressRepository extends BaseEloquentCrudRepository
{

    public function tableName() : string
    {
        return 'blockchain_address';
    }

    public function getEntityClass() : string
    {
        return AddressEntity::class;
    }


}

