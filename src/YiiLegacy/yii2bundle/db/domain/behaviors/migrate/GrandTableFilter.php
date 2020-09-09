<?php

namespace yii2bundle\db\domain\behaviors\migrate;

use yii\base\Behavior;
use yii\helpers\ArrayHelper;
use yii2rails\app\domain\helpers\EnvService;
use yii2bundle\db\domain\enums\EventEnum;
use yii2bundle\db\domain\events\TableEvent;
use yii2bundle\db\domain\helpers\PostgresHelper;
use yii2bundle\db\domain\helpers\SqlHelper;

class GrandTableFilter extends Behavior {
	
	public $users;
	
	public function events() {
		return [
			EventEnum::AFTER_CREATE_TABLE => 'afterCreateTable',
		];
	}
	
	public function afterCreateTable(TableEvent $event) {
		$defaultSchema = PostgresHelper::getDefaultSchema();
		if(empty($defaultSchema)) {
			return;
		}
		$users = $this->getUsers($this->users);
		foreach($users as $user) {
			$sqlList = $this->generateSql($defaultSchema, $user);
			SqlHelper::execute($sqlList);
		}
	}
	
	private function getUsers($users) {
		if(empty($users)) {
			$users = EnvService::getConnection('main.username');
		}
		$users = ArrayHelper::toArray($users);
		return $users;
	}
	
	private function generateSql($defaultSchema, $user) {
		if(empty($defaultSchema) || empty($user)) {
			return null;
		}
		return [
			'GRANT USAGE ON SCHEMA ' . $defaultSchema . ' TO ' . $user,
			'GRANT SELECT, UPDATE, DELETE, INSERT ON ALL TABLES IN SCHEMA ' . $defaultSchema . ' TO ' . $user,
			'GRANT USAGE ON ALL SEQUENCES IN SCHEMA ' . $defaultSchema . ' TO ' . $user,
		];
	}
	
}
