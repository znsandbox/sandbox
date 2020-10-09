<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2020_08_31_115030_create_eav_attribute_table extends BaseCreateTableMigration
{

    protected $tableName = 'eav_attribute';
    protected $tableComment = 'Атрибуты';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->string('name')->comment('Внутреннее имя');
            $table->string('type')->comment('Тип данных');
            $table->boolean('is_required')->nullable()->default(false)->comment('Обязательность заполнения');
            $table->string('default')->nullable()->comment('Значение поумолчанию');
            $table->string('title')->comment('Название');
            $table->string('description')->nullable()->comment('Описание');
            $table->integer('unit_id')->nullable()->comment('Единица измерения');
            $table->integer('status')->default(1)->comment('Статус');

            $table
                ->foreign('unit_id')
                ->references('id')
                ->on($this->encodeTableName('eav_measure'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
        };
    }

}