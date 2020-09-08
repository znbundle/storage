<?php

namespace ZnBundle\Storage\Domain\Services;

use ZnCore\Base\Domain\Base\BaseCrudService;
use ZnBundle\Storage\Domain\Interfaces\Services\FileServiceInterface;

class FileService extends BaseCrudService implements FileServiceInterface
{

    public function __construct(\ZnBundle\Storage\Domain\Interfaces\Repositories\FileRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


}

