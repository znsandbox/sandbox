<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnCore\Db\Migration\Base\BaseCreateTableMigration;
use ZnCore\Db\Migration\Enums\ForeignActionEnum;

class m_2020_03_17_100001_create_user_telegram_table extends BaseCreateTableMigration
{

    protected $tableName = 'user_telegram';
    protected $tableComment = 'Пользователь Telegram';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор в telegram');
            $table->string('login')->comment('Логин в telegram');
            $table->integer('identity_id')->nullable()->comment('Учетная запись пользователя');
            $table
                ->foreign('identity_id')
                ->references('id')
                ->on($this->encodeTableName('user_identity'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
        };
    }

}
