<?php

namespace PhpLab\Sandbox\Bot\Domain\Services;

use PhpLab\Sandbox\Bot\Domain\Interfaces\Services\WordServiceInterface;
use PhpLab\Core\Domain\Base\BaseCrudService;

class WordService extends BaseCrudService implements WordServiceInterface
{

    public function __construct(\PhpLab\Sandbox\Bot\Domain\Interfaces\Repositories\WordRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


}

