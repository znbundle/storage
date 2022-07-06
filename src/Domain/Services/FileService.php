<?php

namespace ZnBundle\Storage\Domain\Services;

use ZnBundle\Storage\Domain\Entities\FileEntity;
use ZnBundle\Storage\Domain\Interfaces\Services\FileServiceInterface;
use ZnCore\Service\Base\BaseCrudService;
use ZnCore\EntityManager\Interfaces\EntityManagerInterface;

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
        $fileEntity = $this->findOneById($id);
        parent::deleteById($id);
        unlink($fileEntity->getFileName());
    }
}
