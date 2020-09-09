<?php

namespace yii2bundle\db\domain\entities;

use yii2rails\domain\BaseEntity;

/**
 * Class ColumnEntity
 * 
 * @package yii2bundle\db\domain\entities
 * 
 * @property $name
 * @property $type
 * @property $php_type
 * @property $default_value
 * @property $size
 * @property $precision
 * @property $is_primary_key
 * @property $is_autoincrement
 * @property $is_unsigned
 * @property $comment
 */
class ColumnEntity extends BaseEntity {

	protected $name;
	protected $type;
	protected $php_type;
	protected $default_value;
	protected $size;
	protected $precision;
	protected $is_primary_key;
	protected $is_autoincrement;
	protected $is_unsigned;
	protected $comment;

}
