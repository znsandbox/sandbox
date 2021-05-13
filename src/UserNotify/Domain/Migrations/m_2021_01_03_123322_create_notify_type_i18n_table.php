<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2021_01_03_123322_create_notify_type_i18n_table extends BaseCreateTableMigration
{

    protected $tableName = 'notify_type_i18n';
    protected $tableComment = 'Переводы шаблонов уведомлений';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->integer('type_id')->comment('Тип уведомления');
            $table->string('language_code')->comment('Код языка');
            $table->string('subject')->comment('Тема');
            $table->string('content')->comment('Содержание');

            $table->unique(['type_id', 'language_code']);
            $table
                ->foreign('language_code')
                ->references('code')
                ->on($this->encodeTableName('language'))
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
