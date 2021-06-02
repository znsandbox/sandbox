<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2021_05_13_055407_create_type_transport_table extends BaseCreateTableMigration
{

    protected $tableName = 'notify_type_transport';
    protected $tableComment = 'Связка шаблонов и транспорта';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->integer('type_id')->comment('ID шаблона');
            $table->integer('transport_id')->comment('ID транспорта');
            $table->integer('status_id')->comment('Статус');

            $table->unique(['type_id', 'transport_id']);

            $this->addForeign($table, 'type_id', 'notify_type');
            $this->addForeign($table, 'transport_id', 'notify_transport');

            /*$table
                ->foreign('type_id')
                ->references('id')
                ->on($this->encodeTableName('notify_type'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
            $table
                ->foreign('transport_id')
                ->references('id')
                ->on($this->encodeTableName('notify_transport'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);*/
        };
    }
}