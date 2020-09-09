<?php

namespace yii2bundle\db\domain\behaviors\migrate;

use yii\base\Behavior;
use yii2bundle\db\domain\enums\DbDriverEnum;
use yii2bundle\db\domain\enums\EventEnum;
use yii2bundle\db\domain\events\TableEvent;

class TableCommentFilter extends Behavior {
	
	public function events() {
		return [
			EventEnum::AFTER_CREATE_TABLE => 'afterCreateTable',
		];
	}
	
	public function afterCreateTable(TableEvent $event) {
		if(!empty($event->sender->comment)) {
			if($event->sender->db->driverName != DbDriverEnum::PGSQL) {
				$event->sender->addCommentOnTable($event->table, $event->sender->comment);
			}
		}
	}
	
}
