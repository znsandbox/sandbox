<?php

namespace yii2bundle\rbac\api\controllers;

use yii2bundle\geo\domain\enums\GeoPermissionEnum;
use yii2bundle\rbac\domain\entities\BaseItemEntity;
use yii2bundle\rbac\domain\entities\RoleEntity;
use yii2bundle\rbac\domain\enums\RbacPermissionEnum;
use yii2bundle\rest\domain\rest\Controller;
use yii2rails\domain\data\Query;
use yii2rails\extension\web\helpers\Behavior;
use yubundle\reference\domain\entities\ItemEntity;

class MapController extends Controller
{

    public function actionIndex1111() {
        $query = new Query;
        $query->with('children');
        /** @var RoleEntity[] $collection */
        $collection = \App::$domain->rbac->role->all($query);
        //d($collection);
        $map = [];
        foreach ($collection as $roleEntity) {
            $roleTitle = "{$roleEntity->description}";
            //$roleTitle .= " ({$roleEntity->name})";
            $map[$roleTitle] = [];
            if($roleEntity->children) {
                foreach ($roleEntity->children as $itemEntity) {
                    $itemTitle = "{$itemEntity->description}";
                    //$itemTitle .= " ({$itemEntity->name})";
                    $map[$roleTitle][] = $itemTitle;
                }
            }
        }
        return $map;
    }

    public function actionIndex() {
        /** @var RoleEntity[] $roleCollection */
        $roleCollection = \App::$domain->rbac->role->all();
        foreach ($roleCollection as $roleEntity) {
            $this->getRelations($roleEntity);
        }
        //d($roleCollection);

        return $this->map($roleCollection);
        //return $this->renderCollection($roleCollection);

        return $roleCollection;
    }

    private function renderCollection($roleCollection) {
        $text = '';
        foreach ($roleCollection as $roleEntity) {
            $roleTitle = $this->getItemTitle($roleEntity);
            $text = PHP_EOL . '# ' . $roleTitle . PHP_EOL . PHP_EOL;

        }
        return $text;
    }

    private function getRelations(RoleEntity $roleEntity) {
        //$roleEntity->children = \App::$domain->rbac->item->getPermissionsByRole($roleEntity->name);
        $roleEntity->roles = \App::$domain->rbac->item->getChildRoles($roleEntity->name);
        $roleEntity->permissions = \App::$domain->rbac->item->getChildren($roleEntity->name);
    }

    private function map(array $roleCollection) {
        $map = [];
        foreach ($roleCollection as $roleEntity) {
            $roleTitle = $this->getItemTitle($roleEntity);
            $map[$roleTitle] = $this->mapRole($roleEntity);
        }
        return $map;
    }

    private function getItemTitle($roleEntity) {
        $title = "{$roleEntity->description}";
        //$title .= " ({$roleEntity->name})";
        return $title;
    }

    private function mapRole(RoleEntity $roleEntity) {
        $map = [];
        if($roleEntity->roles) {
            $roles = [];
            foreach ($roleEntity->roles as $itemEntity) {
                $itemTitle = $this->getItemTitle($itemEntity);
                if($itemEntity->name != $roleEntity->name) {
                    $roles[] = $itemTitle;
                }
            }
            $map['Наследует полномочия ролей'] = array_unique($roles);
        }
        if($roleEntity->permissions) {
            $permissions = [];
            foreach ($roleEntity->permissions as $itemEntity) {
                $itemTitle = $this->getItemTitle($itemEntity);
                if(!in_array($itemTitle, $roles)) {
                    $permissions[] = $itemTitle;
                }
            }
            $map['Полномочия'] = array_unique($permissions);
        }
        return $map;
    }

    public function actionView($id) {
        /** @var RoleEntity $roleEntity */
        $roleEntity = \App::$domain->rbac->role->oneById($id);
        $this->getRelations($roleEntity);

        return $this->mapRole($roleEntity);

        //$roleCollection = \App::$domain->rbac->item->getAllChildren();
        //$roleCollection = \App::$domain->rbac->item->getPermissionsByRole($id);


        //$roleEntity = $roleCollection[$id];
       // $roleEntity = \App::$domain->rbac->item->repository->getAllItems();
        //$roleEntity = \App::$domain->rbac->item->repository->getAllChildren();
        d($roleCollection);
    }

}
