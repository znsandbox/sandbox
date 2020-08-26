<?php

namespace PhpLab\Sandbox\RestClient\Domain\Repositories\Eloquent;

use Illuminate\Support\Collection;
use PhpLab\Core\Domain\Libs\Query;
use PhpLab\Eloquent\Db\Base\BaseEloquentCrudRepository;
use PhpLab\Sandbox\RestClient\Domain\Entities\BookmarkEntity;
use PhpLab\Sandbox\RestClient\Domain\Enums\StatusEnum;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Repositories\BookmarkRepositoryInterface;

class BookmarkRepository extends BaseEloquentCrudRepository implements BookmarkRepositoryInterface
{

    protected $tableName = 'restclient_bookmark';

    public function getEntityClass(): string
    {
        return BookmarkEntity::class;
    }

    public function removeByHash(string $hash): void
    {
        $bookmarkEntity = $this->oneByHash($hash);
        $this->deleteById($bookmarkEntity->getId());
    }

    public function oneByHash(string $hash): BookmarkEntity
    {
        $query = new Query;
        $query->where('hash', $hash);
        return $this->one($query);
    }

    public function allFavoriteByProject(int $projectId): Collection
    {
        $query = new Query;
        $query->where('status', StatusEnum::FAVORITE);
        $query->where('project_id', $projectId);
        return $this->all($query);
    }

    public function allHistoryByProject(int $projectId): Collection
    {
        $query = new Query;
        $query->where('status', StatusEnum::HISTORY);
        $query->where('project_id', $projectId);
        return $this->all($query);
    }

    public function clearHistory(int $projectId): void
    {
        $this->deleteByCondition([
            'project_id' => $projectId,
            'status' => StatusEnum::HISTORY,
        ]);
    }

}

