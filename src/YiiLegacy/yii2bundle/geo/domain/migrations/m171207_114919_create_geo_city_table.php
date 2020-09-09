<?php

use yii2bundle\db\domain\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `city`.
*/
class m171207_114919_create_geo_city_table extends Migration
{
	public $table = '{{%geo_city}}';
    public $tableComment = 'Город';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(),
			'country_id' => $this->integer(),
			'region_id' => $this->integer(),
			'name' => $this->string(128),
		];
	}

	public function afterCreate()
	{
		$this->myAddForeignKey(
			'country_id',
			'{{%geo_country}}',
			'id',
			'CASCADE',
			'CASCADE'
		);
        $this->myAddForeignKey(
            'region_id',
            '{{%geo_region}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
	}

}
