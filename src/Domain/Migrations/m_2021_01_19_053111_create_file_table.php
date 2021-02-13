<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2021_01_19_053111_create_file_table extends BaseCreateTableMigration
{

    protected $tableName = 'storage_file';
    protected $tableComment = '';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->string('hash')->comment('');
            $table->string('extension')->comment('');
            $table->integer('size')->comment('Размер');
            $table->string('name')->comment('');
            $table->string('description')->nullable()->comment('');
            $table->integer('status_id')->comment('');
            $table->dateTime('created_at')->comment('Время создания');
            $table->dateTime('updated_at')->nullable()->comment('Время обновления');

            $table->unique(['hash', 'extension']);
        };
    }
}