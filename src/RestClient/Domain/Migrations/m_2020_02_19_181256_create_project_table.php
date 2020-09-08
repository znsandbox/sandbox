<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnCore\Db\Migration\Base\BaseCreateTableMigration;

class m_2020_02_19_181256_create_project_table extends BaseCreateTableMigration
{

    protected $tableName = 'restclient_project';
    protected $tableComment = '';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->string('name')->comment('Имя проекта');
            $table->string('title')->comment('Название');
            //$table->string('url')->comment('Ссылка на API');
            $table->smallInteger('status')->comment('Статус');
            $table->unique(['name']);
        };
    }

}
