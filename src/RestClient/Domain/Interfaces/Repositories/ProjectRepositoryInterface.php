<?php

namespace ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Repositories;

use ZnCore\Base\Domain\Interfaces\Repository\CrudRepositoryInterface;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnSandbox\Sandbox\RestClient\Domain\Entities\ProjectEntity;

interface ProjectRepositoryInterface extends CrudRepositoryInterface
{

    /**
     * @param string $projectName
     * @return ProjectEntity
     * @throws NotFoundException
     */
    public function oneByName(string $projectName): ProjectEntity;

}
