<?php

namespace PhpLab\Sandbox\RestClient\Domain\Services;

use common\enums\rbac\PermissionEnum;
use PhpLab\Core\Domain\Entities\Query\Where;
use PhpLab\Core\Domain\Enums\OperatorEnum;
use PhpLab\Core\Domain\Helpers\EntityHelper;
use PhpLab\Core\Domain\Libs\Query;
use PhpLab\Core\Exceptions\NotFoundException;
use PhpLab\Sandbox\RestClient\Domain\Entities\ProjectEntity;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Repositories\AccessRepositoryInterface;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Repositories\BookmarkRepositoryInterface;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Repositories\ProjectRepositoryInterface;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use PhpLab\Core\Domain\Base\BaseCrudService;
use Yii;
use yii\web\NotFoundHttpException;

class ProjectService extends BaseCrudService implements ProjectServiceInterface
{

    private $bookmarkRepository;
    private $accessRepository;

    public function __construct(
        ProjectRepositoryInterface $repository,
        BookmarkRepositoryInterface $bookmarkRepository,
        AccessRepositoryInterface $accessRepository
    )
    {
        $this->repository = $repository;
        $this->bookmarkRepository = $bookmarkRepository;
        $this->accessRepository = $accessRepository;
    }

    public function allWithoutUserId(int $userId)
    {
        $accessCollection = $this->accessRepository->allByUserId($userId);
        $projectIds = EntityHelper::getColumn($accessCollection, 'project_id');
        $query = new Query;
        $where = new Where('id', $projectIds, OperatorEnum::EQUAL, 'and', true);
        $query->whereNew($where);
        return $this->all($query);
    }

    public function allByUserId(int $userId)
    {
        $accessCollection = $this->accessRepository->allByUserId($userId);
        $projectIds = EntityHelper::getColumn($accessCollection, 'project_id');
        $query = new Query;
        $query->where('id', $projectIds);
        return $this->all($query);
    }

    public function isAllowProject(int $projectId, int $userId)
    {
        if (Yii::$app->user->can(PermissionEnum::BACKEND_ALL)) {
            return true;
        }
        try {
            $this->accessRepository->oneByTie($projectId, $userId);
            return true;
        } catch (NotFoundException $e) {
            return false;
        }
    }

    public function oneByName(string $projectName): ProjectEntity
    {
        return $this->repository->oneByName($projectName);
    }

    public function projectNameByHash(string $tag): string
    {
        try {
            $bookmarkEntity = $this->bookmarkRepository->oneByHash($tag);
        } catch (NotFoundException $e) {
            throw new NotFoundHttpException('Project not found!');
        }

        try {
            $projectEntity = $this->oneById($bookmarkEntity->getProjectId());
        } catch (NotFoundException $e) {
            throw new NotFoundHttpException('Project not found!');
        }
        return $projectEntity->getName();
    }
}

