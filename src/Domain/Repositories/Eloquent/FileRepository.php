<?php

namespace ZnBundle\Storage\Domain\Repositories\Eloquent;

use ZnBundle\Storage\Domain\Entities\FileEntity;
use ZnBundle\Storage\Domain\Interfaces\Repositories\FileRepositoryInterface;
use ZnLib\Db\Base\BaseEloquentCrudRepository;

class FileRepository extends BaseEloquentCrudRepository implements FileRepositoryInterface
{

    protected $tableName = 'storage_file';

    public function getEntityClass(): string
    {
        return FileEntity::class;
    }
}
