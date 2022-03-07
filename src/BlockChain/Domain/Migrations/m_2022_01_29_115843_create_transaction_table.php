<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnDatabase\Migration\Domain\Base\BaseCreateTableMigration;

class m_2022_01_29_115843_create_transaction_table extends BaseCreateTableMigration
{

    protected $tableName = 'blockchain_transaction';
    protected $tableComment = '';

    public function tableStructure(Blueprint $table): void
    {
        $table->integer('id')->autoIncrement()->comment('Идентификатор');
        $table->bigInteger('amount')->nullable()->comment('');
        $table->longText('payload')->nullable()->comment('');
        $table->string('digest')->comment('');
        $table->string('from_address')->comment('');
        $table->string('to_address')->comment('');
        $table->text('signature')->comment('');
        $table->bigInteger('created_at')->comment('Время создания');



        $this->addForeign($table, 'from_address', 'blockchain_address', 'address');
        $this->addForeign($table, 'to_address', 'blockchain_address', 'address');
    }
}