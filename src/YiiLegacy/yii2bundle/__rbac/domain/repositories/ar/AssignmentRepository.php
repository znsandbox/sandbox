<?php

namespace yii2bundle\rbac\domain\repositories\ar;

use yii2rails\extension\activeRecord\repositories\base\BaseActiveArRepository;
use yii2bundle\rbac\domain\interfaces\repositories\AssignmentInterface;
use yii2bundle\rbac\domain\repositories\traits\AssignmentTrait;

class AssignmentRepository extends BaseActiveArRepository implements AssignmentInterface {
	
	use AssignmentTrait;
	
	protected $primaryKey = null;

}