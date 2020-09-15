<?php

namespace yii2bundle\db\domain\drivers\db;

use yii2rails\extension\common\helpers\Helper;

class MysqlDriver extends BaseDriver
{
	
	public function disableForeignKeyChecks($table)
	{
		$this->executeSql('SET foreign_key_checks = 0');
	}
	
	protected function showTables()
	{
		$all = $this->createSql('SHOW TABLES')->queryAll();
		$dbname = Helper::getDbConfig('dbname');
		$result = [];
		foreach($all as $item) {
			$result[] = $item['Tables_in_' . $dbname];
		}
		return $result;
	}
	
}
