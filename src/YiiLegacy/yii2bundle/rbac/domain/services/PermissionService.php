<?php

namespace yii2bundle\rbac\domain\services;

use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;
use yii\rbac\Permission;
use yii\web\NotFoundHttpException;
use yii2bundle\rbac\domain\entities\PermissionEntity;
use yii2bundle\rbac\domain\interfaces\services\PermissionInterface;
use yii2rails\domain\BaseEntity;
use yii2rails\domain\data\Query;
use yii2rails\domain\exceptions\UnprocessableEntityHttpException;
use yii2rails\domain\helpers\ErrorCollection;
use yii2rails\domain\services\base\BaseActiveService;
use yii2rails\domain\services\base\BaseService;
use yii2bundle\rbac\domain\interfaces\services\RoleInterface;

/**
 * Class PermissionService
 *
 * @package yii2bundle\rbac\domain\services
 *
 * @property \yii2bundle\rbac\domain\Domain $domain
 * @property \yii2bundle\rbac\domain\interfaces\repositories\PermissionInterface $repository
 */
class PermissionService extends BaseActiveService implements PermissionInterface {

    public function updateById($id, $data)
    {
        return $this->repository->updateById($id, $data);
    }

}
