<?php

namespace yii2bundle\db\domain\helpers;

use yii2rails\app\domain\enums\AppEnum;
use yii2rails\app\domain\helpers\EnvService;
use yii2bundle\db\domain\enums\DbDriverEnum;
use Yii;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii2bundle\db\domain\entities\TableEntity;
use yii2bundle\db\domain\helpers\DbHelper;
use yii2bundle\db\domain\helpers\TableHelper;
use yii2rails\extension\console\helpers\input\Question;
use yii2rails\extension\console\helpers\input\Select;
use yii2rails\extension\console\helpers\Output;
use yii2rails\domain\data\EntityCollection;
use yii2tool\vendor\domain\entities\TestEntity;
use yii2rails\extension\console\helpers\input\Enter;
use yii2bundle\db\domain\helpers\MigrationHelper;

class DiffHelper {

    const NOT_EXISTS_MESSAGE = '-not exists-';

    public static $skipColumnValues = [];

    public static function getMaps($connectionNames) {
        $map = [];
        foreach ($connectionNames as $connectionName) {
            $connectionMap = EnvService::getServer('db.' . $connectionName . '.map', []);
            if($connectionMap) {
                $map = ArrayHelper::merge($map, $connectionMap);
            }
        }
        return $map;
    }

    public static function diff($tableNames, $connectionNames) {
        $dbInstances = self::getDbInstancesByConnectionNames($connectionNames);
        /** @var TableEntity[][] $tableEntityCollection */
        $tableEntityCollection = self::getTableEntityCollectionFromDbInstances($dbInstances, $tableNames);

        $connectionName1 = $connectionNames[0];
        $connectionName2 = $connectionNames[1];
        $diff[$connectionName1] = self::diff1($tableEntityCollection, $tableNames, $connectionName1, $connectionName2);
        $diff[$connectionName2] = self::diff1($tableEntityCollection, $tableNames, $connectionName2, $connectionName1);
        return $diff;
    }

    private static function isSkip($k, $value1, $value2) {
        if(array_key_exists($k, self::$skipColumnValues) && empty(self::$skipColumnValues[$k])) {
            return true;
        }
        if(empty(self::$skipColumnValues[$k])) {
            return false;
        }
        $skipValues = self::$skipColumnValues[$k];
        foreach ($skipValues as $values) {
            if(in_array($value1, $values) && in_array($value2, $values)) {
                return true;
            }
        }
        return false;
    }

    private static function diffTable($tableEntity1, $tableEntity2, $globalName) {
        $tableErrors = [];

        if(empty($tableEntity1) || empty($tableEntity2)) {
            return null;
        }

        if($tableEntity1->primary_key != $tableEntity2->primary_key) {
            $tableErrors['primary_key'] = [
                $tableEntity1->primary_key,
                $tableEntity2->primary_key,
            ];
        }
        //$tableErrors['primary_key'] = array_diff_assoc($tableEntity1->primary_key, $tableEntity2->primary_key);

        foreach ($tableEntity1->foreign_keys as $foreignEntity1) {
            $name = $foreignEntity1->self_field;
            if(!empty($tableEntity2->foreign_keys[$foreignEntity1->self_field])) {
                $foreignEntity2 = $tableEntity2->foreign_keys[$foreignEntity1->self_field];
                if($foreignEntity1->self_field != $foreignEntity2->self_field) {
                    $tableErrors['foreign_keys'][$name]['self_field'] = [
                        $foreignEntity1->self_field,
                        $foreignEntity2->self_field,
                    ];
                }
                if($foreignEntity1->rel_field != $foreignEntity2->rel_field) {
                    $tableErrors['foreign_keys'][$name]['rel_field'] = [
                        $foreignEntity1->rel_field,
                        $foreignEntity2->rel_field,
                    ];
                }
            } else {
                $tableErrors['foreign_keys'][$name] = self::NOT_EXISTS_MESSAGE;
            }
        }

        foreach ($tableEntity1->columns as $columnEntity1) {
            if(empty($tableEntity2->columns[$columnEntity1->name])) {
                $tableErrors['columns'][$columnEntity1->name] = self::NOT_EXISTS_MESSAGE;
            } else {
                $columnEntity2 = $tableEntity2->columns[$columnEntity1->name];
                foreach ($columnEntity1->toArray() as $k => $v) {
                    $v2 = $columnEntity2->{$k};
                    if($v != $v2) {
                        $isSkip = self::isSkip($k, $v, $v2);
                        if(!$isSkip) {
                            $tableErrors['columns'][$columnEntity1->name][$k] = [$v, $columnEntity2->{$k}];
                        }
                    }
                }
            }
        }
        return $tableErrors;
    }

    private static function diff1($tableEntityCollection, $tableNames, $connectionName1, $connectionName2) {
        $allTables = [];
        $tables = [];
        foreach ($tableNames as $globalName) {
            $tableEntity1 = $tableEntityCollection[$connectionName1][$globalName];
            $tableEntity2 = $tableEntityCollection[$connectionName2][$globalName];
            if(!empty($tableEntity1) && !empty($tableEntity2)) {
                $diff = self::diffTable($tableEntity1, $tableEntity2, $globalName);
                if($diff) {
                    $allTables[$globalName] = $diff;
                }
            } elseif(empty($tableEntity2)) {
                $allTables[$globalName] = self::NOT_EXISTS_MESSAGE;
            }
        }
        return $allTables;
    }

    private static function getDbInstancesByConnectionNames($connectionNames) {
        foreach ($connectionNames as $connectionName) {
            $dbInstances[$connectionName] = DbHelper::getDbInstanceFromConnectionName($connectionName);
        }
        return $dbInstances;
    }

    private static function getTableEntityCollectionFromDbInstances($dbInstances,  $tableNames) {
        $collection = [];
        foreach ($dbInstances as $dbName => $dbInstance) {
            foreach ($tableNames as $globalTableName) {
                $collection[$dbName][$globalTableName] = self::getTableSchema($dbName, $globalTableName);
            }
        }
        return $collection;
    }

    private static function getTableSchema($connectionName, $globalTableName) {
        $connectionMap = EnvService::getServer('db.' . $connectionName . '.map', []);
        $tableName = TableHelper::getGlobalName($globalTableName, $connectionMap);
        $dbInstance = DbHelper::getDbInstanceFromConnectionName($connectionName);
        $tableSchema = $dbInstance->getTableSchema($tableName);
        if(!empty($tableSchema)) {
            $tableEntity = new TableEntity;
            $tableEntity->name = $tableSchema->name;
            $tableEntity->global_name = $tableSchema->name;
            $tableEntity->connection = $connectionName;
            $tableEntity->schema = $tableSchema->schemaName;
            $tableEntity->primary_key = $tableSchema->primaryKey;
            $tableEntity->foreign_keys = $tableSchema->foreignKeys;
            $tableEntity->columns = $tableSchema->columns;
            return $tableEntity;
        } else {
            return null;
        }
    }
}
