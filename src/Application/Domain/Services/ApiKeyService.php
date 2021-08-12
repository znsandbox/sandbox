<?php

namespace ZnSandbox\Sandbox\Application\Domain\Services;

use ZnSandbox\Sandbox\Application\Domain\Interfaces\Services\ApiKeyServiceInterface;
use ZnCore\Base\Libs\RandomString;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Application\Domain\Interfaces\Repositories\ApiKeyRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnSandbox\Sandbox\Application\Domain\Entities\ApiKeyEntity;

/**
 * @method
 * ApiKeyRepositoryInterface getRepository()
 */
class ApiKeyService extends BaseCrudService implements ApiKeyServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return ApiKeyEntity::class;
    }
    public function create($data): EntityIdInterface
    {
        $generator = new RandomString();
        $generator->addCharactersAll();
        $generator->setLength(32);

        $data['value'] = $generator->generateString();
//        dd($attributes);
        return parent::create($data);
    }
}
