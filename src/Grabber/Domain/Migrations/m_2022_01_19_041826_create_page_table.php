<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;

class m_2022_01_19_041826_create_page_table extends BaseCreateTableMigration
{

    protected $tableName = 'grabber_page';
    protected $tableComment = '';

    public function tableStructure(Blueprint $table): void
    {
        $table->integer('id')->autoIncrement()->comment('Идентификатор');
        $table->integer('site_id')->comment('');
        $table->string('hash')->comment('');
        $table->string('uri')->comment('');
        $table->string('query')->nullable()->comment('');
        $table->string('title')->nullable()->comment('Название');
        $table->string('content')->nullable()->comment('');
        $table->smallInteger('status_id')->comment('Статус');
        $table->dateTime('created_at')->comment('Время создания');
        $table->dateTime('updated_at')->nullable()->comment('Время обновления');
        
        $table->unique(['hash']);
        $this->addForeign($table, 'site_id', 'grabber_site');
    }
}