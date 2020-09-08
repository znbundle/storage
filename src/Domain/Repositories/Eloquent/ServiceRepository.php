<?php

namespace ZnBundle\Storage\Domain\Repositories\Eloquent;

use ZnBundle\Storage\Domain\Entities\ServiceEntity;
use ZnCore\Db\Db\Base\BaseEloquentCrudRepository;
use ZnBundle\Storage\Domain\Interfaces\Repositories\ServiceRepositoryInterface;

class ServiceRepository extends BaseEloquentCrudRepository implements ServiceRepositoryInterface
{

    protected $tableName = 'storage_service';

    public function getEntityClass(): string
    {
        return ServiceEntity::class;
    }
}

