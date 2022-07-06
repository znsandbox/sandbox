<?php

namespace ZnSandbox\Sandbox\Redmine\Domain\Services;

use ZnCore\Service\Base\BaseCrudService;
use ZnCore\EntityManager\Interfaces\EntityManagerInterface;
use ZnSandbox\Sandbox\Redmine\Domain\Entities\IssueApiEntity;
use ZnSandbox\Sandbox\Redmine\Domain\Interfaces\Repositories\IssueApiRepositoryInterface;
use ZnSandbox\Sandbox\Redmine\Domain\Interfaces\Services\IssueApiServiceInterface;

/**
 * @method IssueApiRepositoryInterface getRepository()
 */
class IssueApiService extends BaseCrudService implements IssueApiServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass(): string
    {
        return IssueApiEntity::class;
    }
}
