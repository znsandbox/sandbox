<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;

class m_2021_06_10_111313_create_type_table extends BaseCreateTableMigration
{

    protected $tableName = 'organization_type';
    protected $tableComment = '';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->string('title')->comment('Название');
        };
    }
}