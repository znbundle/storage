<?php

namespace ZnBundle\Storage\Domain\Services;

use ZnCore\Base\Domain\Base\BaseCrudService;
use ZnBundle\Storage\Domain\Interfaces\Services\ServiceServiceInterface;

class ServiceService extends BaseCrudService implements ServiceServiceInterface
{

    public function __construct(\ZnBundle\Storage\Domain\Interfaces\Repositories\ServiceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


}

