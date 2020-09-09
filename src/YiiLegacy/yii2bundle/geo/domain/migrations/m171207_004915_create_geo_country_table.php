<?php

use yii2bundle\db\domain\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `country`.
*/
class m171207_004915_create_geo_country_table extends Migration
{
	public $table = '{{%geo_country}}';
    public $tableComment = 'Страна';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(),
			'name' => $this->string(128),
			'alpha2' => $this->string(2),
			'alpha3' => $this->string(3),
		];
	}

	public function afterCreate()
	{
		//$this->myCreateIndexUnique(['name_short']);
		//$this->myCreateIndexUnique(['name_full']);
	}

}
