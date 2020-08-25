<?php

namespace PhpBundle\Storage\Domain\Repositories\Eloquent;

use PhpBundle\Storage\Domain\Entities\FileEntity;
use PhpBundle\Storage\Domain\Interfaces\Repositories\FileRepositoryInterface;
use PhpLab\Eloquent\Db\Base\BaseEloquentCrudRepository;

class FileRepository extends BaseEloquentCrudRepository implements FileRepositoryInterface
{

    protected $tableName = 'storage_file';

    public function getEntityClass(): string
    {
        return FileEntity::class;
    }
}
