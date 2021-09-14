<?php

namespace ZnSandbox\Sandbox\RpcClient\Domain\Services;

use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Base\Libs\I18Next\Exceptions\NotFoundBundleException;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\Query;
use ZnLib\Rpc\Domain\Libs\RpcAuthProvider;
use ZnLib\Rpc\Domain\Libs\RpcProvider;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Services\FavoriteServiceInterface;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Services\UserServiceInterface;

/**
 * @method
 * FavoriteRepositoryInterface getRepository()
 */
class FavoriteService extends BaseCrudService implements FavoriteServiceInterface
{

    private $authService;

    public function __construct(
        EntityManagerInterface $em,
        AuthServiceInterface $authService
    )
    {
        $this->setEntityManager($em);
        $this->authService = $authService;
    }

    public function getEntityClass(): string
    {
        return FavoriteEntity::class;
    }

    public function addFavorite(FavoriteEntity $favoriteEntity)
    {
        $favoriteEntity->setStatusId(StatusEnum::ENABLED);
        $favoriteEntity->setAuthorId($this->authService->getIdentity()->getId());
        if($favoriteEntity->getId()) {

            try {
                $favoriteEntityUnique = $this->getRepository()->oneByUnique($favoriteEntity);
                //if($favoriteEntityUnique->getId() != $favoriteEntityUnique->getId()) {
                    $this->getRepository()->deleteById($favoriteEntityUnique->getId());
                //}
            } catch (NotFoundException $e) {}

            $this->persist($favoriteEntity);
//            $this->getRepository()->update($favoriteEntity);
        } else {
            try {
//                $favoriteEntityUnique = $this->getRepository()->oneByUnique($favoriteEntity);
                $favoriteEntity = $this->getRepository()->oneByUnique($favoriteEntity);
            } catch (NotFoundException $e) {}
//            $this->getRepository()->update($favoriteEntity);
            $this->persist($favoriteEntity);
        }
        //dd(EntityHelper::toArray($favoriteEntity));
    }

    public function allFavorite(Query $query = null)
    {
        $query = $this->forgeQuery($query);
        $query->orderBy([
            'method' => SORT_ASC,
        ]);
        $query->with(['auth']);
        $query->where('status_id', StatusEnum::ENABLED);
        return parent::all($query);
    }

    public function allHistory(Query $query = null)
    {
        $query = $this->forgeQuery($query);
        $query->orderBy([
            'method' => SORT_ASC,
        ]);
        $query->with(['auth']);
        $query->where('status_id', StatusEnum::WAIT_APPROVING);
        return parent::all($query);
    }
}
