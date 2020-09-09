<?php

namespace yii2bundle\db\domain\interfaces;

interface DbDriverInterface
{
	
	public function loadData($table);
	public function saveData($table, $data);
	public function getNameList();
	public function beginTransaction();
	public function commitTransaction();
	public function clearTable($table);
	
}
