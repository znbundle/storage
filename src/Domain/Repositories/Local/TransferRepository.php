<?php

namespace PhpBundle\Storage\Domain\Repositories\Local;

use PhpBundle\Storage\Domain\Entities\TransferEntity;
use PhpBundle\Storage\Domain\Interfaces\Repositories\TransferRepositoryInterface;

class TransferRepository implements TransferRepositoryInterface
{

    protected $tableName = 'storage_transfer';

    public function getEntityClass(): string
    {
        return TransferEntity::class;
    }

}
