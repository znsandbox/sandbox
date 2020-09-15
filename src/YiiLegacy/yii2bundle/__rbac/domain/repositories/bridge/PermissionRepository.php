<?php

namespace yii2bundle\rbac\domain\repositories\bridge;

use yii\rbac\Permission;
use yii2bundle\rbac\domain\entities\PermissionEntity;
use yii2bundle\rbac\domain\enums\ItemTypeEnum;
use yii2bundle\rbac\domain\interfaces\repositories\PermissionInterface;
use yii2rails\domain\repositories\BaseRepository;
use yii2rails\domain\data\Query;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;
use yii\web\NotFoundHttpException;
use yii2rails\domain\BaseEntity;
use yii2rails\domain\exceptions\UnprocessableEntityHttpException;
use yii2rails\domain\helpers\ErrorCollection;
use yii2rails\domain\services\base\BaseActiveService;
use yii2rails\domain\services\base\BaseService;
use yii2rails\extension\arrayTools\helpers\ArrayIterator;
use yii2rails\extension\enum\base\BaseEnum;

/**
 * Class PermissionRepository
 *
 * @package yii2bundle\rbac\domain\repositories\bridge
 *
 * @property-read \yii2bundle\rbac\domain\Domain $domain
 */
class PermissionRepository extends BaseItemRepository implements PermissionInterface {

    protected $schemaClass = true;

    public function all(Query $query = null)
    {
        $all = \App::$domain->rbac->item->getPermissions();
        $collection = $this->allToCollection($all);
        $iterator = new ArrayIterator;
        $iterator->setCollection($collection);
        $collection = $iterator->all($query);
        foreach ($collection as $item) {
            $this->loadRelations($item, $query);
        }
        return $collection;
    }

    public function oneById($id, Query $query = null)
    {
        $item = \App::$domain->rbac->item->getPermission($id);
        if(empty($item)) {
            throw new NotFoundHttpException();
        }
        $roleEntity = $this->forgeEntityFromItem($item);
        $this->loadRelations($roleEntity, $query);
        return $roleEntity;
    }

    public function insert(BaseEntity $entity)
    {
        $item = new Permission;
        $this->forgeItemFromData($item, $entity->toArray());
        $this->checkExistsByName($item);
        \App::$domain->rbac->item->addItem($item);
    }

    public function updateById($id, $data)
    {
        $item = \App::$domain->rbac->item->getPermission($id);
        if(empty($item)) {
            throw new NotFoundHttpException();
        }
        $data['name'] = $id;
        $this->forgeItemFromData($item, $data);
        //$this->checkExistsByName($item);
        \App::$domain->rbac->item->updateItem($id, $item);
    }

    public function truncate()
    {
        \App::$domain->rbac->item->removeAllPermissions();
    }

    public function deleteById($id)
    {
        $item = \App::$domain->rbac->item->getPermission($id);
        if(empty($item)) {
            throw new NotFoundHttpException();
        }
        \App::$domain->rbac->item->removeItem($item);
    }

}
