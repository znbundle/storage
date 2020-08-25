<?php

namespace PhpBundle\Storage\Domain\Services;

use PhpLab\Core\Domain\Base\BaseCrudService;
use PhpBundle\Storage\Domain\Interfaces\Services\FileServiceInterface;

class FileService extends BaseCrudService implements FileServiceInterface
{

    public function __construct(\PhpBundle\Storage\Domain\Interfaces\Repositories\FileRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


}

