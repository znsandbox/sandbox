<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnCore\Db\Migration\Base\BaseCreateTableMigration;
use ZnCore\Db\Migration\Enums\ForeignActionEnum;

if ( ! class_exists(m_2020_03_12_131839_create_environment_table::class)) {

    class m_2020_03_12_131839_create_environment_table extends BaseCreateTableMigration
    {

        protected $tableName = 'restclient_environment';
        protected $tableComment = '';

        public function tableSchema()
        {
            return function (Blueprint $table) {
                $table->integer('id')->autoIncrement()->comment('Идентификатор');
                $table->integer('project_id')->comment('');
                $table->boolean('is_main')->default(false)->comment('');
                $table->string('title')->comment('');
                $table->string('url')->comment('');
                $table
                    ->foreign('project_id')
                    ->references('id')
                    ->on($this->encodeTableName('restclient_project'))
                    ->onDelete(ForeignActionEnum::CASCADE)
                    ->onUpdate(ForeignActionEnum::CASCADE);
                $table->unique(['project_id', 'url']);
                $table->unique(['project_id', 'title']);
            };
        }
    }

}