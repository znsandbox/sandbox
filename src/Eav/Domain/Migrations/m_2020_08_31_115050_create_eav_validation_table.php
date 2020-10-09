<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2020_08_31_115050_create_eav_validation_table extends BaseCreateTableMigration
{

    protected $tableName = 'eav_validation';
    protected $tableComment = 'Правила валидации';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->integer('attribute_id')->comment('Атрибут');
            $table->string('name')->comment('Внутреннее имя');
            $table->text('params')->nullable()->comment('Параметры валидатора');
            $table->integer('sort')->default(10)->comment('Порядок сортировки');
            $table->integer('status')->default(1)->comment('Статус');

            $table
                ->foreign('attribute_id')
                ->references('id')
                ->on($this->encodeTableName('eav_attribute'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
        };
    }

}