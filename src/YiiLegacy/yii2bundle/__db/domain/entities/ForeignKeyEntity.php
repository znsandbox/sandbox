<?php

namespace yii2bundle\db\domain\entities;

use yii2rails\domain\BaseEntity;

/**
 * Class ForeignKeyEntity
 * 
 * @package yii2bundle\db\domain\entities
 * 
 * @property $name
 * @property $table
 * @property $fields
 * @property $self_field
 * @property $rel_field
 */
class ForeignKeyEntity extends BaseEntity {

	protected $name;
	protected $table;
    protected $fields;
	protected $self_field;
	protected $rel_field;

}
