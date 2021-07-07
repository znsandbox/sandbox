<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;

class m_2021_06_10_112424_create_organization_table extends BaseCreateTableMigration
{

    protected $tableName = 'organization_organization';
    protected $tableComment = '';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->text('title_i18n')->comment('Название');
            $table->integer('type_id')->comment('Тип');
            $table->integer('city_id')->comment('Город');
            $table->integer('region_id')->comment('Регион');
            $table->string('bin')->comment('БИН');
            $table->text('description')->nullable()->comment('Описание');
            $table->smallInteger('status_id')->comment('Статус');

            $this->addForeign($table, 'type_id', 'organization_type');
            $this->addForeign($table, 'region_id', 'reference_item');
        };
    }
}