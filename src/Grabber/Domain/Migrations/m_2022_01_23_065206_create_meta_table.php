<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnDatabase\Migration\Domain\Base\BaseCreateTableMigration;

class m_2022_01_23_065206_create_meta_table extends BaseCreateTableMigration
{

    protected $tableName = 'grabber_meta';
    protected $tableComment = '';

    public function tableStructure(Blueprint $table): void
    {
        $table->integer('id')->autoIncrement()->comment('Идентификатор');
        $table->integer('page_id')->comment('');
        $table->string('title')->comment('Название');
        $table->string('site_name')->comment('');
        $table->string('type')->comment('');
        $table->text('description')->comment('Описание');
        $table->text('keywords')->comment('');
        $table->text('image')->comment('');
        $table->text('attributes')->comment('Данные');
        $table->dateTime('created_at')->comment('Время создания');
        $table->dateTime('updated_at')->nullable()->comment('Время обновления');

        $table->unique(['page_id']);
        $this->addForeign($table, 'page_id', 'grabber_queue');
    }
}