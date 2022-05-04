<?php

namespace ZnBundle\Storage\Domain\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use ZnBundle\Storage\Domain\Entities\FileEntity;
use ZnBundle\Storage\Domain\Interfaces\Services\UploadServiceInterface;
use ZnBundle\Storage\Domain\Interfaces\Services\UsageServiceInterface;
use ZnBundle\Storage\Domain\Libs\FileHash;
use ZnCore\Base\Helpers\DeprecateHelper;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnCore\Domain\Base\BaseService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;

class UploadService extends BaseService implements UploadServiceInterface
{

    protected $usageService;
    protected $fileHash;

    public function __construct(
        EntityManagerInterface $em,
        UsageServiceInterface $usageService,
        FileHash $fileHash
    )
    {
        $this->setEntityManager($em);
        $this->usageService = $usageService;
        $this->fileHash = $fileHash;
    }

    public function getEntityClass(): string
    {
        return FileEntity::class;
    }

    public function uploadFile(int $serviceId, int $entityId, UploadedFile $uploadedFile): FileEntity
    {
        $fileEntity = $this->createEntity();
        $fileEntity = $this->prepareEntityFromUploaded($fileEntity, $uploadedFile);
        FileHelper::createDirectory($fileEntity->getDirectory());
        copy($uploadedFile->getRealPath(), $fileEntity->getFileName());
        $this->persistEntity($serviceId, $entityId, $fileEntity);
        return $fileEntity;
    }

    public function makeFile(int $serviceId, ?int $entityId, string $relativeFileName, string $content): FileEntity
    {
        $fileEntity = $this->createEntity();
        $fileEntity = $this->makeEntityByContent($fileEntity, $relativeFileName, $content);
        FileHelper::createDirectory($fileEntity->getDirectory());
        file_put_contents($fileEntity->getFileName(), $content);
        $this->persistEntity($serviceId, $entityId, $fileEntity);
        return $fileEntity;
    }

    protected function prepareEntityFromUploaded(FileEntity $fileEntity, UploadedFile $uploadedFile): FileEntity
    {
        $hashString = $this->fileHash->getHashFromFileName($uploadedFile->getRealPath());
        $name = FileHelper::fileNameOnly($uploadedFile->getClientOriginalName());
        $fileEntity->setHash($hashString);
        $fileEntity->setName($name);
        $fileEntity->setExtension($uploadedFile->getClientOriginalExtension());
        $fileEntity->setSize($uploadedFile->getSize());
        return $fileEntity;
    }

    protected function makeEntityByContent(FileEntity $fileEntity, string $relativeFileName, string $content): FileEntity
    {
        $fileEntity->setName(FileHelper::fileNameOnly($relativeFileName));
        $fileEntity->setExtension(FileHelper::fileExt($relativeFileName));
        $fileEntity->setHash($this->fileHash->getHashFromContent($content));
        $fileEntity->setSize(strlen($content));
        return $fileEntity;
    }

    protected function persistEntity(int $serviceId, int $entityId, FileEntity $fileEntity)
    {
        $this->getEntityManager()->persist($fileEntity);
        $this->usageService->add($serviceId, $entityId, $fileEntity->getId());
    }
}
