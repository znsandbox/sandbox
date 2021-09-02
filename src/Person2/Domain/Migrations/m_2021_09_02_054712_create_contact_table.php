<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;

class m_2021_09_02_054712_create_contact_table extends BaseCreateTableMigration
{

    protected $tableName = 'person_contact';
    protected $tableComment = '';

    public function tableStructure(Blueprint $table): void
    {
        $table->integer('id')->autoIncrement()->comment('Идентификатор');
        $table->integer('person_id')->comment('');
        $table->integer('attribute_id')->comment('');
        $table->string('value')->comment('');
        $table->smallInteger('status_id')->comment('Статус');
        $table->string('sort')->default(100)->comment('');
        $table->dateTime('created_at')->comment('Время создания');
        $table->dateTime('updated_at')->nullable()->comment('Время обновления');

        $table->unique(['person_id', 'value']);

        $this->addForeign($table, 'person_id', 'person_person');
        $this->addForeign($table, 'attribute_id', 'eav_attribute');
    }
}