<?php

namespace ZnBundle\Storage\Domain\Services;

use ZnCore\Domain\Base\BaseCrudService;
use ZnBundle\Storage\Domain\Interfaces\Services\TransferServiceInterface;

class TransferService extends BaseCrudService implements TransferServiceInterface
{

    public function __construct(\ZnBundle\Storage\Domain\Interfaces\Repositories\TransferRepositoryInterface $repository)
    {
        $this->setRepository($repository);
    }


}

