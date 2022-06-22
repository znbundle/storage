<?php

namespace ZnBundle\Storage\Domain\Services;

use ZnBundle\Storage\Domain\Entities\FileEntity;
use ZnBundle\Storage\Domain\Interfaces\Services\FileServiceInterface;
use ZnCore\Domain\Service\Base\BaseCrudService;
use ZnCore\Domain\EntityManager\Interfaces\EntityManagerInterface;

class FileService extends BaseCrudService implements FileServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass(): string
    {
        return FileEntity::class;
    }

    public function deleteById($id)
    {
        $fileEntity = $this->oneById($id);
        parent::deleteById($id);
        unlink($fileEntity->getFileName());
    }
}
