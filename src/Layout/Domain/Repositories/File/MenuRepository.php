<?php

namespace ZnSandbox\Sandbox\Layout\Domain\Repositories\File;

use ZnSandbox\Sandbox\Layout\Domain\Entities\MenuEntity;
use ZnSandbox\Sandbox\Layout\Domain\Interfaces\Repositories\MenuRepositoryInterface;
use ZnDomain\Сomponents\FileRepository\Base\BaseFileCrudRepository;

class MenuRepository extends BaseFileCrudRepository implements MenuRepositoryInterface
{

    private $fileName;

    public function getEntityClass(): string
    {
        return MenuEntity::class;
    }

    public function setFileName( string $fileName): void
    {
        $this->fileName = $fileName;
    }

    public function fileName(): string
    {
        return $this->fileName;
    }
}
