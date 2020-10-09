<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2020_08_31_115011_create_eav_measure_table extends BaseCreateTableMigration
{

    protected $tableName = 'eav_measure';
    protected $tableComment = 'Единицы измерения';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->integer('parent_id')->nullable()->comment('Базовая единица измерения');
            $table->string('name')->nullable()->comment('Внутреннее имя');
            $table->string('title')->comment('Название');
            $table->string('short_title')->nullable()->comment('Короткое название');
            $table->float('rate')->default(1)->comment('Коэффициент');

            $table->unique(['name']);

            $table
                ->foreign('parent_id')
                ->references('id')
                ->on($this->encodeTableName('eav_measure'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
        };
    }

}