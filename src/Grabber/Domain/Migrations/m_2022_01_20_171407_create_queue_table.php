<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;

class m_2022_01_20_171407_create_queue_table extends BaseCreateTableMigration
{

    protected $tableName = 'grabber_queue';
    protected $tableComment = '';

    public function tableStructure(Blueprint $table): void
    {
        $table->integer('id')->autoIncrement()->comment('Идентификатор');
        $table->integer('site_id')->comment('');
        $table->string('hash')->comment('');
        $table->string('path')->comment('');
        $table->string('query')->nullable()->comment('');
        $table->string('content')->nullable()->comment('');
        $table->string('type')->comment('');
        $table->smallInteger('status_id')->comment('Статус');
        $table->dateTime('created_at')->comment('Время создания');
        $table->dateTime('updated_at')->nullable()->comment('Время обновления');

        $table->unique(['hash']);
        $this->addForeign($table, 'site_id', 'grabber_site');
    }
}