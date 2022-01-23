<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;

class m_2022_01_23_065240_create_content_table extends BaseCreateTableMigration
{

    protected $tableName = 'grabber_content';
    protected $tableComment = '';

    public function tableStructure(Blueprint $table): void
    {
        $table->integer('id')->autoIncrement()->comment('Идентификатор');
        $table->integer('page_id')->comment('');
        $table->longText('content')->comment('');
        $table->dateTime('created_at')->comment('Время создания');
        $table->dateTime('updated_at')->nullable()->comment('Время обновления');

        $table->unique(['page_id']);
        $this->addForeign($table, 'page_id', 'grabber_queue');
    }
}