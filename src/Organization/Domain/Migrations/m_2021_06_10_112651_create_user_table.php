<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnDatabase\Migration\Domain\Base\BaseCreateTableMigration;

class m_2021_06_10_112651_create_user_table extends BaseCreateTableMigration
{

    protected $tableName = 'organization_user';
    protected $tableComment = '';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->integer('user_id')->comment('ID учетной записи пользователя');
            $table->integer('organization_id')->comment('');
            $table->smallInteger('status_id')->comment('Статус');
        };
    }
}