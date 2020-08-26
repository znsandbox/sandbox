<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use PhpLab\Eloquent\Migration\Base\BaseCreateTableMigration;
use PhpLab\Eloquent\Migration\Enums\ForeignActionEnum;

class m_2020_02_22_101059_create_authorization_table extends BaseCreateTableMigration
{

    protected $tableName = 'restclient_authorization';
    protected $tableComment = '';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->integer('project_id')->comment('');
            $table->string('type')->comment('');
            $table->string('username')->comment('');
            $table->string('password')->comment('');
            $table
                ->foreign('project_id')
                ->references('id')
                ->on($this->encodeTableName('restclient_project'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
            $table->unique(['project_id', 'type', 'username']);
        };
    }

}
