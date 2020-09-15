<?php

namespace yii2bundle\rbac\domain\interfaces\services;

use yii2rails\domain\interfaces\services\CrudInterface;

/**
 * Interface PermissionInterface
 * 
 * @package yii2bundle\rbac\domain\interfaces\services
 * 
 * @property-read \yii2bundle\rbac\domain\Domain $domain
 * @property-read \yii2bundle\rbac\domain\interfaces\repositories\PermissionInterface $repository
 */
interface PermissionInterface extends CrudInterface {

}
