<?php

namespace PhpBundle\Storage\Domain\Services;

use PhpLab\Core\Domain\Base\BaseCrudService;
use PhpBundle\Storage\Domain\Interfaces\Services\ServiceServiceInterface;

class ServiceService extends BaseCrudService implements ServiceServiceInterface
{

    public function __construct(\PhpBundle\Storage\Domain\Interfaces\Repositories\ServiceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


}

