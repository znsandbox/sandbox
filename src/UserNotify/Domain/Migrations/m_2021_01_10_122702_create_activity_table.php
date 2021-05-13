<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2021_01_10_122702_create_activity_table extends BaseCreateTableMigration
{

    protected $tableName = 'notify_activity';
    protected $tableComment = 'История отправленных уведомлений (SMS, Email)';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->integer('type_id')->comment('Шаблон уведомления');
            $table->string('entity_name')->comment('Имя сущности-источника');
            $table->integer('entity_id')->comment('ID сущности-источника');
            $table->integer('user_id')->comment('ID пользователя');
            $table->string('action')->comment('Действие');
            $table->text('attributes')->comment('Атрибуты для шаблона');
            $table->dateTime('created_at')->comment('Время создания');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on($this->encodeTableName('user_identity'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
            /*$table
                ->foreign('type_id')
                ->references('id')
                ->on($this->encodeTableName('notify_type'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);*/
        };
    }
}