<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;

class m_2022_01_19_041032_create_site_table extends BaseCreateTableMigration
{

    protected $tableName = 'grabber_site';
    protected $tableComment = '';

    public function tableStructure(Blueprint $table): void
    {
        $table->integer('id')->autoIncrement()->comment('Идентификатор');
        $table->string('host')->comment('');
        $table->string('title')->nullable()->comment('Название');
        
        $table->unique(['host']);
    }
}