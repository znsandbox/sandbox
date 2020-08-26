<?php

namespace PhpLab\Sandbox\RestClient\Domain\Services;

use Illuminate\Support\Collection;
use PhpLab\Core\Domain\Helpers\EntityHelper;
use PhpLab\Core\Exceptions\NotFoundException;
use PhpLab\Sandbox\RestClient\Domain\Entities\BookmarkEntity;
use PhpLab\Sandbox\RestClient\Domain\Enums\StatusEnum;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Repositories\BookmarkRepositoryInterface;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Services\BookmarkServiceInterface;
use PhpLab\Core\Domain\Base\BaseCrudService;

class BookmarkService extends BaseCrudService implements BookmarkServiceInterface
{

    public function __construct(BookmarkRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function persist(object $bookmarkEntity) {
        $bookmarkEntity->setId(null);
        try {
            $bookmarkEntity = $this->repository->oneByHash($bookmarkEntity->getHash());
            $this->repository->update($bookmarkEntity);
        } catch (NotFoundException $e) {
            $bookmarkEntity->setStatus(StatusEnum::HISTORY);
            $this->repository->create($bookmarkEntity);
        }
        return $bookmarkEntity;
    }

    public function createOrUpdate(array $data): BookmarkEntity {
        $bookmarkEntity = new BookmarkEntity;
        unset($data['id']);
        EntityHelper::setAttributes($bookmarkEntity, $data);
        try {
            $bookmarkEntity = $this->repository->oneByHash($bookmarkEntity->getHash());
            $this->repository->update($bookmarkEntity);
        } catch (NotFoundException $e) {
            $bookmarkEntity->setStatus(StatusEnum::HISTORY);
            $this->repository->create($bookmarkEntity);
        }
        return $bookmarkEntity;
    }

    public function addToCollection(string $hash): BookmarkEntity {
        $bookmarkEntity = $this->repository->oneByHash($hash);
        $bookmarkEntity->setStatus(StatusEnum::FAVORITE);
        $this->repository->update($bookmarkEntity);
        return $bookmarkEntity;
    }

    public function removeByHash(string $hash): void {
        $this->repository->removeByHash($hash);
    }

    public function oneByHash(string $hash): BookmarkEntity {
        return $this->repository->oneByHash($hash);
    }

    public function allFavoriteByProject(int $projectId): Collection {
        return $this->repository->allFavoriteByProject($projectId);
    }

    public function allHistoryByProject(int $projectId): Collection {
        return $this->repository->allHistoryByProject($projectId);
    }

    public function clearHistory(int $projectId): void {
        $this->repository->clearHistory($projectId);
    }
}
