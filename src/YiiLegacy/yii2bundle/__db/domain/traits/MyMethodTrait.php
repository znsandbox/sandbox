<?php

namespace yii2bundle\db\domain\traits;

use Yii;
use yii2bundle\db\domain\helpers\MigrationHelper;
use yii2bundle\db\domain\helpers\TableHelper;

trait MyMethodTrait {

    public function tableName() {
        return self::getTableName($this->table);
    }

    protected function getTableName($table) {
        $table = MigrationHelper::pureTableName($table);
        $table = TableHelper::getGlobalName($table);
        return MigrationHelper::yiiTableName($table);
    }

    protected function generateNameForKey($type, $name, $data = null) {
	    $res = '';
	    $names = explode(DOT, $name);
	    if(count($names) > 1) {
	        $schema = $names[0];
            $table = $names[1];

            return $type . '-' . $table . '-' . hash('crc32b', serialize($data));
        } else {
            $table = $name;
            return $type . '-' . $table . '-' . hash('crc32b', serialize($data));
        }

	}

    protected function myDropForeignKey($columns, $refTable, $refColumns, $delete = 'CASCADE', $update = 'CASCADE') {
        $refTable = self::getTableName($refTable);
        if(Yii::$app->db->driverName == 'sqlite') {
            return null;
        }
        $name = $this->generateNameForKey('fk', MigrationHelper::pureTableName($this->tableName()), [$columns, $refTable, $refColumns]);
        return $this->dropForeignKey($name, $this->tableName());
    }

	protected function myAddForeignKey($columns, $refTable, $refColumns, $delete = 'CASCADE', $update = 'CASCADE') {
        $refTable = self::getTableName($refTable);
        if(Yii::$app->db->driverName == 'sqlite') {
			return null;
		}
		$name = $this->generateNameForKey('fk', MigrationHelper::pureTableName($this->tableName()), [$columns, $refTable, $refColumns]);
		return $this->addForeignKey($name, $this->tableName(), $columns, $refTable, $refColumns, $delete, $update);
	}
	
	protected function myCreateIndex($columns, $unique = false) {
		$columns = is_array($columns) ? $columns : [$columns];
		$type = $unique ? 'uni' : 'idx';
		$name = $this->generateNameForKey($type, MigrationHelper::pureTableName($this->tableName()), $columns);
		return parent::createIndex($name, $this->tableName(), $columns, $unique);
	}
	
	protected function myAddPrimaryKey($columns) {
		$columns = is_array($columns) ? $columns : [$columns];
		$name = $this->generateNameForKey('pk', MigrationHelper::pureTableName($this->tableName()), $columns);
		return parent::addPrimaryKey($name, $this->tableName(), $columns);
	}
	
	protected function myCreateIndexUnique($columns) {
		return $this->myCreateIndex($columns, true);
	}
	
}
