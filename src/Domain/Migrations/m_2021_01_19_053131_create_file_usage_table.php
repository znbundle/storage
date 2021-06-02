<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2021_01_19_053131_create_file_usage_table extends BaseCreateTableMigration
{

    protected $tableName = 'storage_file_usage';
    protected $tableComment = 'Использование файлов';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('Идентификатор');
            $table->integer('service_id')->comment('ID категории');
            $table->integer('entity_id')->comment('ID сущности');
            $table->integer('user_id')->comment('ID автора');
            $table->integer('file_id')->comment('ID файла');
            $table->dateTime('created_at')->comment('Время создания');

            $table->unique(['service_id', 'entity_id', 'user_id', 'file_id']);

            $this->addForeign($table, 'service_id', 'storage_service');
            $this->addForeign($table, 'user_id', 'user_identity');
            $this->addForeign($table, 'file_id', 'storage_file');

            /*if($this->isInOneDatabase('storage_service')) {
                $table
                    ->foreign('service_id')
                    ->references('id')
                    ->on($this->encodeTableName('storage_service'))
                    ->onDelete(ForeignActionEnum::CASCADE)
                    ->onUpdate(ForeignActionEnum::CASCADE);
            }

            if($this->isInOneDatabase('user_identity')) {
                $table
                    ->foreign('user_id')
                    ->references('id')
                    ->on($this->encodeTableName('user_identity'))
                    ->onDelete(ForeignActionEnum::CASCADE)
                    ->onUpdate(ForeignActionEnum::CASCADE);
            }

            if($this->isInOneDatabase('storage_file')) {
                $table
                    ->foreign('file_id')
                    ->references('id')
                    ->on($this->encodeTableName('storage_file'))
                    ->onDelete(ForeignActionEnum::CASCADE)
                    ->onUpdate(ForeignActionEnum::CASCADE);
            }*/
        };
    }
}