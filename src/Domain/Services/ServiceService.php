<?php

namespace ZnBundle\Storage\Domain\Services;

use ZnBundle\Storage\Domain\Interfaces\Repositories\ServiceRepositoryInterface;
use ZnBundle\Storage\Domain\Interfaces\Services\ServiceServiceInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;

class ServiceService extends BaseCrudService implements ServiceServiceInterface
{

    public function __construct(EntityManagerInterface $em, ServiceRepositoryInterface $repository)
    {
        $this->setEntityManager($em);
        $this->setRepository($repository);
    }
}
