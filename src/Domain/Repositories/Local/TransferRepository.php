<?php

namespace ZnBundle\Storage\Domain\Repositories\Local;

use ZnBundle\Storage\Domain\Entities\TransferEntity;
use ZnBundle\Storage\Domain\Interfaces\Repositories\TransferRepositoryInterface;

class TransferRepository implements TransferRepositoryInterface
{

    protected $tableName = 'storage_transfer';

    public function getEntityClass(): string
    {
        return TransferEntity::class;
    }

}
