<?php

namespace yii2bundle\db\domain\helpers;

use Yii;
use yii2rails\extension\code\helpers\generator\ClassGeneratorHelper;

class MigrationHelper {
	
	public static function pureTableName($table) {
		$table = str_replace(['{', '}', '%'], '', $table);
		return $table;
	}

    public static function yiiTableName($table) {
        $table = '{{%' . $table . '}}';
        return $table;
    }

    public static function normalizeYiiTableName($table) {
        $table = self::pureTableName($table);
        return self::yiiTableName($table);
    }
	
	public static function getTableNameOfClass($className) {
		$className = basename($className);
		$classNameArr = explode('_', $className);
		$classNameArrStriped = array_slice($classNameArr, 3, -1);
		$table = implode('_', $classNameArrStriped);
		return $table;
	}
	
	public static function generateByTableName($tableName, $namespace = 'console\migrations') {
		$tableSchema = Yii::$app->db->getTableSchema($tableName);
		$tableName = TableHelper::getLocalName($tableName);
		$className = self::getClassName($tableName, $namespace);
		$config = [
			'className' => $className,
			'use' => ['yii2bundle\db\domain\db\MigrationCreateTable as Migration'],
			'afterClassName' => 'extends Migration',
			'code' => self::getCode($tableName, $tableSchema),
			'namespace' => null,
		];
		ClassGeneratorHelper::generate($config);
		return $className;
	}
	
	private static function getClassName($tableName, $namespace) {
		$prefix = 'm' . gmdate('ymd_His');
		$namespace = str_replace(SL, BSL, $namespace);
		$className = $namespace . BSL . $prefix . "_create_{$tableName}_table";
		return $className;
	}
	
	private static function generateValueCode($columnData) {
		if($columnData->isPrimaryKey) {
			$columnCode = "\$this->primaryKey({$columnData->size})";
		} elseif($columnData->type == 'timestamp') {
			$columnCode = "\$this->timestamp()->defaultValue(null)";
		} else {
			$columnCode = "\$this->{$columnData->phpType}({$columnData->size})";
		}
		if(empty($columnData->allowNull)) {
			$columnCode .= "->notNull()";
		}
		if(!empty($columnData->defaultValue)) {
			$columnCode .= "->defaultValue({$columnData->defaultValue})";
		}
		if(!empty($columnData->comment)) {
			$columnCode .= "->comment('{$columnData->comment}')";
		}
		return $columnCode;
	}
	
	private static function generateColumnsCode($columns) {
		$columnArr = [];
		foreach($columns as $columnName => $columnData) {
			$columnCode = self::generateValueCode($columnData);
			$columnArr[] = "'{$columnName}' => {$columnCode},";
		}
		$columnStr = implode("\n\t\t\t", $columnArr);
		return $columnStr;
	}
	
	private static function generateKeysCode($tableSchema) {
		$keysArr = [];
		
		foreach($tableSchema->foreignKeys as $foreign) {
			foreach($foreign as $kk => $rr) {
				if(!is_integer($kk)) {
                    $foreignTable = $foreign[0];
                    $foreignTable = TableHelper::getLocalName($foreignTable);
					$keysArr[] = "\$this->myAddForeignKey(
			'{$kk}',
			'{$foreignTable}',
			'{$rr}',
			'CASCADE',
			'CASCADE'
		);";
				}
			}
		}
		
		$keysStr = implode("\n\t\t", $keysArr);
		return $keysStr;
	}
	
	private static function getCode($tableName, $tableSchema) {
		$columnStr = self::generateColumnsCode($tableSchema->columns);
		$keysStr = self::generateKeysCode($tableSchema);
		$code = <<<CODE
	public \$table = '{$tableName}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			{$columnStr}
		];
	}

	public function afterCreate()
	{
		{$keysStr}
	}
CODE;
		return $code;
	}
	
}