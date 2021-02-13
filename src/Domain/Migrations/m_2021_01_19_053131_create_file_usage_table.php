<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2021_01_19_053131_create_file_usage_table extends BaseCreateTableMigration
{

    protected $tableName = 'storage_file_usage';
    protected $tableComment = '';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->integer('service_id')->comment('');
            $table->integer('entity_id')->comment('');
            $table->integer('user_id')->comment('');
            $table->integer('file_id')->comment('');
            $table->dateTime('created_at')->comment('Время создания');

            $table->unique(['service_id', 'entity_id', 'user_id', 'file_id']);
            $table
                ->foreign('service_id')
                ->references('id')
                ->on($this->encodeTableName('storage_service'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
            $table
                ->foreign('user_id')
                ->references('id')
                ->on($this->encodeTableName('user_identity'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
            $table
                ->foreign('file_id')
                ->references('id')
                ->on($this->encodeTableName('storage_file'))
                ->onDelete(ForeignActionEnum::CASCADE)
                ->onUpdate(ForeignActionEnum::CASCADE);
        };
    }
}