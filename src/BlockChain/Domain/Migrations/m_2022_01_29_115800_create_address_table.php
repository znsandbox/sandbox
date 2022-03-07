<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnDatabase\Migration\Domain\Base\BaseCreateTableMigration;

class m_2022_01_29_115800_create_address_table extends BaseCreateTableMigration
{

    protected $tableName = 'blockchain_address';
    protected $tableComment = '';

    public function tableStructure(Blueprint $table): void
    {
        $table->integer('id')->autoIncrement()->comment('Идентификатор');
        $table->string('address')->comment('');
        $table->string('hash')->comment('');
        $table->text('public_key')->comment('');

        $table->unique(['address']);
    }
}