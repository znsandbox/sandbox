<?php

namespace ZnSandbox\Sandbox\Geo\Domain\Services;

use ZnSandbox\Sandbox\Geo\Domain\Entities\LocalityEntity;
use ZnSandbox\Sandbox\Geo\Domain\Interfaces\Services\LocalityServiceInterface;
use ZnSandbox\Sandbox\Geo\Domain\Subscribers\AssignCountryIdSubscriber;
use Yii;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\Query;

/**
 * @method
 * LocalityRepositoryInterface getRepository()
 */
class LocalityService extends BaseCrudService implements LocalityServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return LocalityEntity::class;
    }

    public function subscribes(): array
    {
        return [
            AssignCountryIdSubscriber::class,
        ];
    }

    protected function forgeQuery(Query $query = null)
    {
        $parentQuery = parent::forgeQuery($query);
        if ($regionId = Yii::$app->request->get('region_id')) {
            $parentQuery->where('region_id', (int)$regionId);
        }
        return $parentQuery;
    }

}

