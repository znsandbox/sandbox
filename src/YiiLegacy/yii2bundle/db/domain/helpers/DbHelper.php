<?php

namespace yii2bundle\db\domain\helpers;

use yii\db\Connection;
use yii\helpers\ArrayHelper;
use yii2rails\app\domain\enums\AppEnum;
use yii2rails\app\domain\helpers\EnvService;
use yii2bundle\db\domain\enums\DbDriverEnum;

class DbHelper {

    public static function tableNameList()
    {
        $driver = ConnectionHelper::getDriverFromDb(\Yii::$app->db);
        if($driver == DbDriverEnum::PGSQL) {
            $schemaNames = \Yii::$app->db->schema->getSchemaNames();
        } else {
            $schemaNames = [''];
        }
        $tables = [];
        foreach ($schemaNames as $schemaName) {
            $tableColumns = \Yii::$app->db->schema->getTableSchemas($schemaName);
            $tableNames = ArrayHelper::getColumn($tableColumns, 'name');
            foreach ($tableNames as $tableName) {
                $table = $schemaName . DOT . $tableName;
                $tables[] = trim($table, DOT);
            }
        }
        return $tables;
    }

    public static function getDbInstanceFromConnectionName($connectionName) {
        $connectionConfig = EnvService::getConnection($connectionName);
        $dbConfig = DbHelper::adapterConfig($connectionConfig);
        return new Connection($dbConfig);
    }

	public static function getConfigFromEnv($name) {
		$connectionFromEnv = EnvService::getConnection($name);
		$connectionFromEnv = DbHelper::adapterConfig($connectionFromEnv);
		return $connectionFromEnv;
	}

    public static function adapterConfig($connection) {
		$connection = self::forgeMigrator($connection);
		if($connection['driver'] == DbDriverEnum::PGSQL) {
			$connection = PostgresHelper::postgresSchemaMap($connection);
		}
		
		if(empty($connection['dsn'])) {
			$connection['dsn'] = self::getDsn($connection);
		}
		
		$connection = self::clean($connection);
		return $connection;
	}
	
	private static function forgeMigrator($connection) {
		if(empty($connection['migrator'])) {
			return $connection;
		}
		$migrator = $connection['migrator'];
		unset($connection['migrator']);
		if(APP != AppEnum::CONSOLE) {
			return $connection;
		}
		foreach($migrator as $name => $value) {
			$connection[$name] = $value;
		}
		return $connection;
	}
	
	private static function getDsn($connection) {
		if($connection['driver'] == DbDriverEnum::SQLITE) {
			$connection['dsn'] = $connection['driver'] . ':' . $connection['dbname'];
		} else {
			$connection['host'] = isset($connection['host']) ? $connection['host'] : 'localhost';
			
			$dsn = $connection['driver'] . ':';
			$dsnParams = [];
			$dsnParams[] = 'host=' . $connection['host'];
			if(isset($connection['port'])) {
				$dsnParams[] = 'port=' . $connection['port'];
			}
			$dsnParams[] = 'dbname=' . $connection['dbname'];
			
			$connection['dsn'] = $connection['driver'] . ':' . implode(';', $dsnParams);
		}
		return $connection['dsn'];
	}
	
	private static function clean($connection) {
		unset($connection['driver']);
		unset($connection['host']);
		unset($connection['port']);
		unset($connection['dbname']);
        unset($connection['map']);
		return $connection;
	}
	
}
