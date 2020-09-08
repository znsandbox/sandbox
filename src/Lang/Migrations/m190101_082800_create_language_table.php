<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnCore\Db\Migration\Base\BaseCreateTableMigration;
use ZnCore\Db\Migration\Enums\ForeignActionEnum;

class m190101_082800_create_language_table extends BaseCreateTableMigration
{

    protected $tableName = 'language';
    protected $tableComment = 'Язык';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->string('code')->comment('Код языка');
            $table->string('title')->comment('Название');
            $table->string('name')->comment('Системное имя');
            $table->string('locale')->comment('Локаль');
            $table->boolean('is_main')->comment('По умолчанию?');
            $table->boolean('is_enabled')->comment('Включен?');

            $table->unique('title');
            $table->unique('name');
            $table->unique('locale');
            $table->primary('code');
        };
    }

}