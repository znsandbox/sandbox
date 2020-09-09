<?php

namespace yii2bundle\rbac\domain\interfaces\services;

interface ConstInterface {
	
	public function generateAll();
	public function generatePermissions();
	public function generateRoles();
	public function generateRules();
	
}