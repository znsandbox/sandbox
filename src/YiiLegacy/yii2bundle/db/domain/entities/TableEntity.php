<?php

namespace yii2bundle\db\domain\entities;

use yii\db\ColumnSchema;
use yii\helpers\ArrayHelper;
use yii2rails\domain\BaseEntity;

/**
 * Class TableEntity
 * 
 * @package yii2bundle\db\domain\entities
 * 
 * @property $name
 * @property $connection
 * @property $schema
 * @property $global_name
 * @property $primary_key
 * @property $foreign_keys
 * @property $columns
 */
class TableEntity extends BaseEntity {

	protected $name;
    protected $connection;
	protected $schema;
    protected $global_name;
	protected $primary_key;
	protected $foreign_keys;
	protected $columns;

	public function setForeignKeys($value) {
	    $collection = [];
	    foreach ($value as $name => $data) {
	        $keyEntity = new ForeignKeyEntity;
            $keyEntity->name = $name;
            $keyEntity->table = $data[0];
            unset($data[0]);
            $keyEntity->self_field = key($data);
            $keyEntity->rel_field = $data[$keyEntity->self_field];
            //$keyEntity->fields = $data;
            $collection[] = $keyEntity;
        }
        $this->foreign_keys = ArrayHelper::index($collection, 'self_field');
    }

    public function setColumns($value) {
	    //d($value);
        $collection = [];
        /**
         * @var  $name
         * @var ColumnSchema $data
         */
        foreach ($value as $name => $data) {
            $keyEntity = new ColumnEntity;
            $keyEntity->name = $name;
            $keyEntity->type = $data->type;
            $keyEntity->php_type = $data->phpType;
            $keyEntity->default_value = $data->defaultValue;
            $keyEntity->size = $data->size;
            $keyEntity->precision = $data->precision;
            $keyEntity->is_primary_key = $data->isPrimaryKey;
            $keyEntity->is_autoincrement = $data->autoIncrement;
            $keyEntity->is_unsigned = $data->unsigned;
            $keyEntity->comment = $data->comment;
            $collection[] = $keyEntity;
        }
        $this->columns = ArrayHelper::index($collection, 'name');
    }

}
