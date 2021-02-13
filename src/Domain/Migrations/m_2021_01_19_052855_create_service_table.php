<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;

class m_2021_01_19_052855_create_service_table extends BaseCreateTableMigration
{

    protected $tableName = 'storage_service';
    protected $tableComment = '';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->string('name')->comment('');
            $table->string('title')->comment('');
            $table->string('path')->comment('');
            $table->string('entity_class')->comment('');
            $table->integer('status_id')->comment('');
            $table->dateTime('created_at')->comment('Время создания');
            $table->dateTime('updated_at')->nullable()->comment('Время обновления');
        };
    }
}