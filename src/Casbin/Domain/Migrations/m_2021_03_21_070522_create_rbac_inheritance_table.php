<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2021_03_21_070522_create_rbac_inheritance_table extends BaseCreateTableMigration
{

    protected $tableName = 'rbac_inheritance';
    protected $tableComment = 'Наследование';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->string('parent')->comment('Родитель');
            $table->string('child')->comment('Ребенок');

            $table->unique(['parent', 'child']);
            $table
                ->foreign('parent')
                ->references('name')
                ->on($this->encodeTableName('rbac_item'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
            $table
                ->foreign('child')
                ->references('name')
                ->on($this->encodeTableName('rbac_item'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
        };
    }
}