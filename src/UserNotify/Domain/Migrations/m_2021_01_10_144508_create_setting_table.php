<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2021_01_10_144508_create_setting_table extends BaseCreateTableMigration
{

    protected $tableName = 'notify_setting';
    protected $tableComment = '';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->integer('user_id')->comment('Пользователь');
            $table->integer('notify_type_id')->comment('Тип уведомления');
            $table->integer('contact_type_id')->comment('Тип контакта');
            $table->boolean('is_enabled')->comment('Включена ли отправка уведомлений');

            $table->unique(['user_id', 'notify_type_id', 'contact_type_id']);
            $table
                ->foreign('user_id')
                ->references('id')
                ->on($this->encodeTableName('user_identity'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
            $table
                ->foreign('notify_type_id')
                ->references('id')
                ->on($this->encodeTableName('notify_type'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
            $table
                ->foreign('contact_type_id')
                ->references('id')
                ->on($this->encodeTableName('person_contact_type'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
        };
    }
}
