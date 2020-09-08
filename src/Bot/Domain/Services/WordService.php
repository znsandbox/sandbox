<?php

namespace ZnSandbox\Sandbox\Bot\Domain\Services;

use ZnSandbox\Sandbox\Bot\Domain\Interfaces\Services\WordServiceInterface;
use ZnCore\Base\Domain\Base\BaseCrudService;

class WordService extends BaseCrudService implements WordServiceInterface
{

    public function __construct(\ZnSandbox\Sandbox\Bot\Domain\Interfaces\Repositories\WordRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


}

