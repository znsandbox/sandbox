<?php

namespace yii2bundle\db\domain\drivers;

use Yii;
use yii2bundle\db\domain\helpers\TableHelper;
use yii2rails\extension\store\StoreFile;
use yii2rails\extension\yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii2bundle\db\domain\interfaces\DriverInterface;
use yii2rails\extension\store\Store;

class DiskDriver implements DriverInterface
{
	
	public function truncateData($table)
	{
        $table = TableHelper::getLocalName($table);
		$file = $this->getFixtureDataDir() . DS . $table . '.php';
		return FileHelper::remove($file);
	}
	
	public function loadData($table)
	{
        $table = TableHelper::getLocalName($table);
		$file = $this->getFixtureDataDir() . DS . $table . '.php';
		return include($file);
	}
	
	public function saveData($table, $data)
	{
        $table = TableHelper::getLocalName($table);
		//$table = $this->getPureTableName($table);
		$this->saveDataFile($table, $data);
		$this->saveFixtureFile($table);
		return true;
	}
	
	/* public function getPureTableName($table)
	{
		$classNameArray = explode('.', $table);
		if(count($classNameArray) > 1) {
			unset($classNameArray[0]);
		}
		$className = implode('.', $classNameArray);
		return $className;
	} */
	
	public function getNameList()
	{
		$options['only'][] = '*.php';
		$fileList = FileHelper::findFiles($this->getFixtureDataDir(), $options);
		$fileList = array_map(function($file) {
			return pathinfo($file, PATHINFO_FILENAME);
		}, $fileList);
		return $fileList;
	}
	
	private function getFixtureDir()
	{
		$fixtureDir = ArrayHelper::getValue(Yii::$app->params, 'fixture.dir', '@common/fixtures');
		return Yii::getAlias($fixtureDir);
	}
	
	private function getFixtureDataDir()
	{
		return $this->getFixtureDir() . DS . 'data';
	}

	private function saveDataFile($table, $rows)
	{
		$rows = $this->indexingDataByPk($table, $rows);
        $table = TableHelper::getLocalName($table);
		$file = $this->getFixtureDataDir() . DS . $table . '.php';
		$store = new StoreFile($file);
		$store->save($rows);
	}

	private function buildPkIndex($pkList, $row)
	{
		$pkString = '';
		foreach($pkList as $pk) {
			$pkString .= $row[$pk] . '.';
		}
		$pkString = trim($pkString, '.');
		return $pkString;
	}
	
	private function indexingDataByPk($table, $rows)
	{
		$schema = Yii::$app->db->schema->getTableSchema($table);
		if(empty($schema->primaryKey)) {
			return $rows;
		}
		$result = [];
		foreach($rows as $row) {
			$pkString = $this->buildPkIndex($schema->primaryKey, $row);
			$result[$pkString] = $row;
		}
		return $result;
	}
	
	private function fixtureClassName($table)
	{
		$camelCaseName = Inflector::id2camel($table, '_');
		$className = ucfirst($camelCaseName) . 'Fixture';
		return $className;
	}
	
	private function generateFixtureClassCode($table)
	{
		$className = $this->fixtureClassName($table);
		$code =
			'<?php' . NS . NS .
			'namespace common\fixtures;' . NS . NS .
			'use yii\test\ActiveFixture;' . NS . NS .
			'class ' . $className . ' extends ActiveFixture' . NS .
			'{' . NS .
			'	public $tableName = \'{{%' . $table . '}}\';' . NS .
			'}';
		return $code;
	}
	
	private function saveFixtureFile($table)
	{
	    return;
		$className = $this->fixtureClassName($table);
		$file = $this->getFixtureDir() . DS . $className . '.php';
		if(file_exists($file)) {
			return false;
		}
		$code = $this->generateFixtureClassCode($table);
		FileHelper::save($file, $code);
	}
	
	public function beginTransaction() {
		// TODO: Implement beginTransaction() method.
	}
	
	public function commitTransaction() {
		// TODO: Implement commitTransaction() method.
	}
	
	public function disableForeignKeyChecks($table) {
		// TODO: Implement disableForeignKeyChecks() method.
	}
}
