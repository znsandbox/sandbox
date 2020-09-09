<?php

use yii2bundle\db\domain\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `region`.
*/
class m171207_104142_create_geo_region_table extends Migration
{
	public $table = '{{%geo_region}}';
    public $tableComment = 'Регион/Область';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(),
			'country_id' => $this->integer(),
			'name' => $this->string(64),
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
	}

}
