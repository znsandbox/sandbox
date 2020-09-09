<?php

namespace yii2bundle\rbac\domain\interfaces\repositories;

interface ManagerInterface {
	
	public function isGuestOnlyAllowed($rule);
	public function isAuthOnlyAllowed($rule);

}