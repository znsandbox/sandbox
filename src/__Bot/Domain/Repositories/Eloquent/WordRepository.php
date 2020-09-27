<?php

namespace ZnSandbox\Sandbox\Bot\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Bot\Domain\Entities\WordEntity;
use ZnSandbox\Sandbox\Bot\Domain\Interfaces\Repositories\WordRepositoryInterface;

class WordRepository extends BaseEloquentCrudRepository implements WordRepositoryInterface
{

    protected $tableName = 'bot_word';

    public function getEntityClass(): string
    {
        return WordEntity::class;
    }
}

