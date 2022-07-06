<?php

namespace ZnBundle\Storage\Domain\Services;

use ZnBundle\Storage\Domain\Interfaces\Repositories\ServiceRepositoryInterface;
use ZnBundle\Storage\Domain\Interfaces\Services\ServiceServiceInterface;
use ZnCore\Domain\Service\Base\BaseCrudService;
use ZnCore\EntityManager\Interfaces\EntityManagerInterface;

class ServiceService extends BaseCrudService implements ServiceServiceInterface
{

    public function __construct(EntityManagerInterface $em, ServiceRepositoryInterface $repository)
    {
        $this->setEntityManager($em);
        $this->setRepository($repository);
    }
}
