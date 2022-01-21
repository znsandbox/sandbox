<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Repositories\Eloquent;

use Illuminate\Support\Collection;
use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Domain\Libs\Query;
use ZnCore\Domain\Relations\relations\OneToOneRelation;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnLib\Db\Mappers\JsonMapper;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\QueueEntity;
use ZnSandbox\Sandbox\Grabber\Domain\Enums\QueueStatusEnum;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Repositories\QueueRepositoryInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Repositories\SiteRepositoryInterface;

class QueueRepository extends BaseEloquentCrudRepository implements QueueRepositoryInterface
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

    public function allNew(Query $query = null): Collection
    {
        $query = $this->forgeQuery($query);
        $query->limit(20);
        $query->where('status_id', StatusEnum::WAIT_APPROVING);
        $query->with('site');
        return $this->all($query);
    }

    public function allGrabed(Query $query = null): Collection
    {
        $query = new Query();
        $query->limit(20);
        $query->where('status_id', StatusEnum::COMPLETED);
        $query->with('site');
        return $this->all($query);
    }

    public function countAll(Query $query = null): int {
        $query = $this->forgeQuery($query);
//        $query->where('status_id', StatusEnum::WAIT_APPROVING);
        return $this->count($query);
    }

    public function countNew(Query $query = null): int {
        $query = $this->forgeQuery($query);
        $query->where('status_id', StatusEnum::WAIT_APPROVING);
        return $this->count($query);
    }

    public function countGrabed(Query $query = null): int {
        $query = $this->forgeQuery($query);
        $query->where('status_id', StatusEnum::COMPLETED);
        return $this->count($query);
    }

    public function countParsed(Query $query = null): int {
        $query = $this->forgeQuery($query);
        $query->where('status_id', QueueStatusEnum::PARSED);
        return $this->count($query);
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
