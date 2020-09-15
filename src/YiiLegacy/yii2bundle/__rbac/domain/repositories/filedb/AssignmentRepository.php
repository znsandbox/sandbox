<?php

namespace yii2bundle\rbac\domain\repositories\filedb;

use yii2rails\extension\filedb\repositories\base\BaseActiveFiledbRepository;
use yii2bundle\rbac\domain\interfaces\repositories\AssignmentInterface;
use yii2bundle\rbac\domain\repositories\traits\AssignmentTrait;

class AssignmentRepository extends BaseActiveFiledbRepository implements AssignmentInterface {
	
	use AssignmentTrait;
	
	protected $primaryKey = null;
	
}