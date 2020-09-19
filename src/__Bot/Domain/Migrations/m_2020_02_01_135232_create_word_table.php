<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnCore\Db\Migration\Base\BaseCreateTableMigration;

class m_2020_02_01_135232_create_word_table extends BaseCreateTableMigration
{

    protected $tableName = 'bot_word';
    protected $tableComment = '';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->string('request')->comment('');
            $table->text('response')->comment('');
        };
    }

}
