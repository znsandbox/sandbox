<?php

namespace PhpLab\Sandbox\Bot\Domain\Repositories\Eloquent;

use PhpLab\Eloquent\Db\Base\BaseEloquentCrudRepository;
use PhpLab\Sandbox\Bot\Domain\Entities\WordEntity;
use PhpLab\Sandbox\Bot\Domain\Interfaces\Repositories\WordRepositoryInterface;

class WordRepository extends BaseEloquentCrudRepository implements WordRepositoryInterface
{

    protected $tableName = 'bot_word';

    public function getEntityClass(): string
    {
        return WordEntity::class;
    }
}

