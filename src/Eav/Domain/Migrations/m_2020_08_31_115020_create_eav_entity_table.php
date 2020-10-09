<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2020_08_31_115020_create_eav_entity_table extends BaseCreateTableMigration
{

    protected $tableName = 'eav_entity';
    protected $tableComment = 'Сущности';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->integer('book_id')->comment('Категория');
            $table->string('name')->comment('Внутреннее имя');
            $table->string('title')->comment('Название');
            $table->text('handler')->nullable()->comment('Класс обработчика');
            $table->integer('status')->default(1)->comment('Статус');

            $table
                ->foreign('book_id')
                ->references('id')
                ->on($this->encodeTableName('eav_category'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);

        };
    }

}