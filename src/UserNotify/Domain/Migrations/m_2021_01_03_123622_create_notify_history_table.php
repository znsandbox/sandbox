<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2021_01_03_123622_create_notify_history_table extends BaseCreateTableMigration
{

    protected $tableName = 'notify_history';
    protected $tableComment = '';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->integer('recipient_id')->comment('Получатель');
            $table->integer('type_id')->nullable()->comment('Тип');
            $table->enum('color', [
                'primary',
                'secondary',
                'success',
                'danger',
                'warning',
                'info',
                'light',
                'dark',
            ])->nullable()->comment('Цвет');
            $table->string('icon')->nullable()->comment('Иконка');
            $table->string('subject')->comment('Заголовок');
            $table->string('content')->comment('Содержание');
            $table->integer('status_id')->comment('Статус');
            $table->dateTime('created_at')->comment('Время создания');

            $table
                ->foreign('recipient_id')
                ->references('id')
                ->on($this->encodeTableName('user_identity'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
            $table
                ->foreign('type_id')
                ->references('id')
                ->on($this->encodeTableName('notify_type'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
        };
    }
}
