<?php

namespace ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Services;

use ZnCore\Domain\Interfaces\Service\CrudServiceInterface;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnSandbox\Sandbox\RestClient\Domain\Entities\ProjectEntity;

interface ProjectServiceInterface extends CrudServiceInterface
{

    public function allWithoutUserId(int $userId);

    public function allByUserId(int $userId);

    public function isAllowProject(int $projectId, int $userId);

    /**
     * @param string $projectName
     * @return ProjectEntity
     * @throws NotFoundException
     */
    public function oneByName(string $projectName): ProjectEntity;

    /**
     * @param string $tag
     * @return string
     * @throws NotFoundException
     */
    public function projectNameByHash(string $tag): string;

}
