<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace ZnSandbox\Sandbox\YiiRbac\Services;

use ZnCore\Base\Exceptions\InvalidArgumentException;
use ZnCore\Base\Exceptions\InvalidValueException;
use ZnCore\Base\Helpers\ClassHelper;
use ZnCore\Base\Legacy\Yii\Base\Component;
use ZnSandbox\Sandbox\YiiRbac\Entities\Item;
use ZnSandbox\Sandbox\YiiRbac\Entities\Permission;
use ZnSandbox\Sandbox\YiiRbac\Entities\Role;
use ZnSandbox\Sandbox\YiiRbac\Entities\Rule;
use ZnSandbox\Sandbox\YiiRbac\Interfaces\ManagerInterface;
use ZnSandbox\Sandbox\YiiRbac\Repositories\BaseManager;

class ManagerService extends Component implements ManagerInterface
{

    private $repository;

    public function __construct(BaseManager $repository, $config = [])
    {
        parent::__construct($config);
        $this->repository = $repository;
    }

    /**
     * @var array a list of role names that are assigned to every user automatically without calling [[assign()]].
     * Note that these roles are applied to users, regardless of their state of authentication.
     */
    protected $defaultRoles = [];

    public function createRole($name)
    {
        $role = new Role();
        $role->name = $name;
        return $role;
    }

    public function createPermission($name)
    {
        $permission = new Permission();
        $permission->name = $name;
        return $permission;
    }

    public function add($object)
    {
        if ($object instanceof Item) {
            if ($object->ruleName && $this->getRule($object->ruleName) === null) {
                $rule = ClassHelper::createObject($object->ruleName);
                $rule->name = $object->ruleName;
                $this->repository->addRule($rule);
            }

            return $this->repository->addItem($object);
        } elseif ($object instanceof Rule) {
            return $this->repository->addRule($object);
        }

        throw new InvalidArgumentException('Adding unsupported object type.');
    }

    public function remove($object)
    {
        if ($object instanceof Item) {
            return $this->repository->removeItem($object);
        } elseif ($object instanceof Rule) {
            return $this->repository->removeRule($object);
        }

        throw new InvalidArgumentException('Removing unsupported object type.');
    }

    public function update($name, $object)
    {
        if ($object instanceof Item) {
            if ($object->ruleName && $this->getRule($object->ruleName) === null) {
                $rule = ClassHelper::createObject($object->ruleName);
                $rule->name = $object->ruleName;
                $this->repository->addRule($rule);
            }

            return $this->repository->updateItem($name, $object);
        } elseif ($object instanceof Rule) {
            return $this->repository->updateRule($name, $object);
        }

        throw new InvalidArgumentException('Updating unsupported object type.');
    }

    public function getRole($name)
    {
        $item = $this->repository->getItem($name);
        return $item instanceof Item && $item->type == Item::TYPE_ROLE ? $item : null;
    }

    public function getPermission($name)
    {
        $item = $this->repository->getItem($name);
        return $item instanceof Item && $item->type == Item::TYPE_PERMISSION ? $item : null;
    }

    public function getRoles()
    {
        return $this->repository->getItems(Item::TYPE_ROLE);
    }

    public function getRolesByUser($userId)
    {
        return $this->repository->getRolesByUser($userId);
    }

    public function getChildRoles($roleName)
    {
        return $this->repository->getChildRoles($roleName);
    }

    public function getPermissionsByRole($roleName)
    {
        return $this->repository->getPermissionsByRole($roleName);
    }

    public function getPermissionsByUser($userId)
    {
        return $this->repository->getPermissionsByUser($userId);
    }

    public function getRule($name)
    {
        return $this->repository->getRule($name);
    }

    public function getRules()
    {
        return $this->repository->getRules();
    }

    public function canAddChild($parent, $child)
    {
        return $this->repository->canAddChild($parent, $child);
    }

    public function addChild($parent, $child)
    {
        return $this->repository->addChild($parent, $child);
    }

    public function removeChild($parent, $child)
    {
        return $this->repository->removeChild($parent, $child);
    }

    public function removeChildren($parent)
    {
        return $this->repository->removeChildren($parent);
    }

    public function hasChild($parent, $child)
    {
        return $this->repository->hasChild($parent, $child);
    }

    public function getChildren($name)
    {
        return $this->repository->getChildren($name);
    }

    public function assign($role, $userId)
    {
        return $this->repository->assign($role, $userId);
    }

    public function revoke($role, $userId)
    {
        return $this->repository->revoke($role, $userId);
    }

    public function revokeAll($userId)
    {
        return $this->repository->revokeAll($userId);
    }

    public function getAssignment($roleName, $userId)
    {
        return $this->repository->getAssignment($roleName, $userId);
    }

    public function getAssignments($userId)
    {
        return $this->repository->getAssignments($userId);
    }

    public function getUserIdsByRole($roleName)
    {
        return $this->repository->getUserIdsByRole($roleName);
    }

    public function removeAll()
    {
        return $this->repository->removeAll();
    }

    public function removeAllPermissions()
    {
        return $this->repository->removeAllPermissions();
    }

    public function removeAllRoles()
    {
        return $this->repository->removeAllRoles();
    }

    public function removeAllRules()
    {
        return $this->repository->removeAllRules();
    }

    public function removeAllAssignments()
    {
        return $this->repository->removeAllAssignments();
    }

    public function checkAccess($userId, $permissionName, $params = [])
    {
        return $this->repository->checkAccess($userId, $permissionName, $params);
    }

    /**
     * Set default roles
     * @param string[]|\Closure $roles either array of roles or a callable returning it
     * @throws InvalidArgumentException when $roles is neither array nor Closure
     * @throws InvalidValueException when Closure return is not an array
     * @since 2.0.14
     */
    public function setDefaultRoles($roles)
    {
        if (is_array($roles)) {
            $this->defaultRoles = $roles;
        } elseif ($roles instanceof \Closure) {
            $roles = call_user_func($roles);
            if (!is_array($roles)) {
                throw new InvalidValueException('Default roles closure must return an array');
            }
            $this->defaultRoles = $roles;
        } else {
            throw new InvalidArgumentException('Default roles must be either an array or a callable');
        }
    }

    /**
     * Get default roles
     * @return string[] default roles
     * @since 2.0.14
     */
    public function getDefaultRoles()
    {
        return $this->defaultRoles;
    }

    /**
     * {@inheritdoc}
     */
    public function getPermissions()
    {
        return $this->repository->getItems(Item::TYPE_PERMISSION);
    }

}
