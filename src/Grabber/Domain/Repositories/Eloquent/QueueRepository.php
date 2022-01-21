<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Repositories\Eloquent;

use Illuminate\Support\Collection;
use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Domain\Libs\Query;
use ZnCore\Domain\Relations\relations\OneToOneRelation;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnLib\Db\Mappers\JsonMapper;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\QueueEntity;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Repositories\SiteRepositoryInterface;

class QueueRepository extends BaseEloquentCrudRepository
{

    public function tableName(): string
    {
        return 'grabber_queue';
    }

    public function getEntityClass(): string
    {
        return QueueEntity::class;
    }

    public function mappers(): array
    {
        return [
            new JsonMapper(['query']),
        ];
    }

    public function allNew(): Collection
    {
        $query = new Query();
        $query->where('status_id', StatusEnum::WAIT_APPROVING);
        $query->with('site');
        return $this->all($query);
    }

    public function relations2()
    {
        return [
            [
                'class' => OneToOneRelation::class,
                'relationAttribute' => 'site_id',
                'relationEntityAttribute' => 'site',
                'foreignRepositoryClass' => SiteRepositoryInterface::class,
            ],
        ];
    }
}
