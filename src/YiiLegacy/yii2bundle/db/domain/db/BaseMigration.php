<?php

namespace yii2bundle\db\domain\db;

use yii\db\Migration;
use yii2bundle\db\domain\helpers\MigrationHelper;
use yii2bundle\db\domain\traits\FieldTypeTrait;
use yii2bundle\db\domain\traits\MyMethodTrait;

abstract class BaseMigration extends Migration {
	
	use FieldTypeTrait;
	use MyMethodTrait;
	
	protected $table;
    public $tableComment;
	
	/**
	 * @inheritdoc
	 */
	public function init() {
		parent::init();
		$this->initTableName();
	}
	
	private function initTableName() {
		if(!empty($this->table)) {
			return;
		}
		$this->table = MigrationHelper::getTableNameOfClass(get_class($this));
	}

	public function array()
    {
        return parent::json();
    }

}
