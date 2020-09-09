<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnCore\Db\Migration\Base\BaseCreateTableMigration;

class m_2020_03_17_100000_create_user_identity_table extends BaseCreateTableMigration
{

    protected $tableName = 'user_identity';
    protected $tableComment = 'Учетная запись пользователя';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->string('login')->comment('Логин');
        };
    }

}
