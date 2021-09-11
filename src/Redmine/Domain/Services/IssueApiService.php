<?php

namespace ZnSandbox\Sandbox\Redmine\Domain\Services;

use ZnSandbox\Sandbox\Redmine\Domain\Interfaces\Services\IssueApiServiceInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Redmine\Domain\Interfaces\Repositories\IssueApiRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnSandbox\Sandbox\Redmine\Domain\Entities\IssueApiEntity;

/**
 * @method
 * IssueApiRepositoryInterface getRepository()
 */
class IssueApiService extends BaseCrudService implements IssueApiServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return IssueApiEntity::class;
    }


}

