<?php

namespace PhpBundle\Storage\Domain\Services;

use PhpLab\Core\Domain\Base\BaseCrudService;
use PhpBundle\Storage\Domain\Interfaces\Services\TransferServiceInterface;

class TransferService extends BaseCrudService implements TransferServiceInterface
{

    public function __construct(\PhpBundle\Storage\Domain\Interfaces\Repositories\TransferRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


}

