<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;

class m_2018_02_25_084640_create_person_table extends BaseCreateTableMigration
{

    protected $tableName = 'person_person';
    protected $tableComment = 'Персоны';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->integer('code')->nullable()->comment('Идентификатор персоны');
            $table->integer('identity_id')->nullable()->comment('Аккаунт');
            $table->string('first_name')->comment('Имя');
            $table->string('middle_name')->nullable()->comment('Отчество');
            $table->string('last_name')->nullable()->comment('Фамилия');
            $table->date('birthday')->nullable()->comment('Дата рождения');
            $table->integer('sex_id')->nullable()->comment('Пол');

            $table->unique(['code']);
            $this->addForeign($table, 'identity_id', 'user_identity');
        };
    }
}
