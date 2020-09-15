<?php

namespace yii2bundle\db\domain\events;

use yii\base\Event;
use yii2bundle\db\domain\db\MigrationCreateTable;

/**
 * @property MigrationCreateTable $sender
 */
class TableEvent extends Event {
	
	public $table;
	public $options;
	
}
