<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Services;

use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Repositories\CategoryRepositoryInterface;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Services\CategoryServiceInterface;
use ZnCore\Domain\Base\BaseCrudService;

class CategoryService extends BaseCrudService implements CategoryServiceInterface
{

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

}
