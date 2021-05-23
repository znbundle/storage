<?php

namespace ZnBundle\Storage\Domain\Services;

use ZnBundle\Storage\Domain\Entities\FileEntity;
use ZnBundle\Storage\Domain\Helpers\UploadHelper;
use ZnBundle\Storage\Domain\Interfaces\Services\UploadServiceInterface;
use ZnBundle\Storage\Domain\Interfaces\Services\UsageServiceInterface;
use ZnBundle\Storage\Domain\Libs\FileHash;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnCore\Base\Libs\DotEnv\DotEnvConfigInterface;
use ZnCore\Domain\Base\BaseService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;

class UploadService extends BaseService implements UploadServiceInterface
{

    private $usageService;
//    private $dotEnvConfig;
    private $fileHash;

    public function __construct(
        EntityManagerInterface $em,
        UsageServiceInterface $usageService,
//        DotEnvConfigInterface $dotEnvConfig,
        FileHash $fileHash
    )
    {
        $this->setEntityManager($em);
        $this->usageService = $usageService;
//        $this->dotEnvConfig = $dotEnvConfig;
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

    public function getTargetFileNameFromUploaded(SymfonyUploadedFile $uploadedFile): string
    {
        $ext = FileHelper::fileExt($uploadedFile->getClientOriginalName());
        $hash = $this->fileHash->getHashFromFileName($uploadedFile->getRealPath());
        return DotEnv::get('STORAGE_PUBLIC_URI') . '/' . $this->fileHash->getPath($hash, $ext);
        //return $this->dotEnvConfig->get('STORAGE_PUBLIC_URI') . '/' . UploadHelper::getTargetFileName($hash, $ext);
    }

    private function prepareEntityFromUploaded(FileEntity $fileEntity, SymfonyUploadedFile $uploadedFile): FileEntity
    {
        $hashString = $this->fileHash->getHashFromFileName($uploadedFile->getRealPath());
        $name = FileHelper::fileNameOnly($uploadedFile->getClientOriginalName());
        $fileEntity->setHash($hashString);
        $fileEntity->setName($name);
        $fileEntity->setExtension($uploadedFile->getClientOriginalExtension());
        $fileEntity->setSize($uploadedFile->getSize());
        return $fileEntity;
    }

    private function makeEntityByContent(FileEntity $fileEntity, string $relativeFileName, string $content): FileEntity
    {
        $fileEntity->setName(FileHelper::fileNameOnly($relativeFileName));
        $fileEntity->setExtension(FileHelper::fileExt($relativeFileName));
        $fileEntity->setHash($this->fileHash->getHashFromContent($content));
        $fileEntity->setSize(strlen($content));
        return $fileEntity;
    }

    /*public function getTargetFileNameFromUploaded(SymfonyUploadedFile $uploadedFile): string
    {
        return $this->dotEnvConfig->get('STORAGE_PUBLIC_URI') . '/' . UploadHelper::getTargetFileNameFromUploaded($uploadedFile);
    }*/

    private function persistEntity(int $serviceId, int $entityId, FileEntity $fileEntity)
    {
        $this->getEntityManager()->persist($fileEntity);
        $this->usageService->add($serviceId, $entityId, $fileEntity->getId());
    }
}
