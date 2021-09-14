<?php

namespace ZnSandbox\Sandbox\RpcClient\Domain\Services;

use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Services\FavoriteServiceInterface;

/**
 * @method
 * FavoriteRepositoryInterface getRepository()
 */
class FavoriteService extends BaseCrudService implements FavoriteServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass(): string
    {
        return FavoriteEntity::class;
    }

    public function allFavorite(Query $query = null)
    {
        $query = $this->forgeQuery($query);
        $query->orderBy([
            'method' => SORT_ASC,
        ]);
        $query->with(['auth']);
        $query->where('status_id', StatusEnum::ENABLED);
        return parent::all($query);
    }

    public function allHistory(Query $query = null)
    {
        $query = $this->forgeQuery($query);
        $query->orderBy([
            'method' => SORT_ASC,
        ]);
        $query->with(['auth']);
        $query->where('status_id', StatusEnum::WAIT_APPROVING);
        return parent::all($query);
    }
}
