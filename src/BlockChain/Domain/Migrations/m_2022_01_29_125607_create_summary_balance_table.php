<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnDatabase\Migration\Domain\Base\BaseCreateTableMigration;

class m_2022_01_29_125607_create_summary_balance_table extends BaseCreateTableMigration
{

    protected $tableName = 'blockchain_summary_balance';
    protected $tableComment = '';

    public function tableStructure(Blueprint $table): void
    {
        $table->integer('id')->autoIncrement()->comment('Идентификатор');
        $table->string('address')->comment('');
        $table->bigInteger('balance')->comment('');
        $table->dateTime('updated_at')->nullable()->comment('Время обновления');

        $table->unique(['address']);
        $this->addForeign($table, 'address', 'blockchain_address', 'address');
    }
}