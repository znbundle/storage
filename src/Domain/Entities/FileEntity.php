<?php

namespace ZnBundle\Storage\Domain\Entities;

use DateTime;
use Illuminate\Support\Collection;
use ZnBundle\Storage\Domain\Helpers\UploadHelper;
use ZnBundle\Storage\Domain\Libs\FileHash;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Base\Helpers\EnumHelper;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Libs\DotEnv\DotEnv;
//use ZnCore\Base\Libs\DotEnv\DotEnvConfigInterface;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Entity\UniqueInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;

class FileEntity implements ValidateEntityByMetadataInterface, EntityIdInterface, UniqueInterface
{

    private $id = null;

    private $hash = null;

    private $extension = null;

    private $size = null;

    private $name = null;

    private $description = null;

    private $statusId = StatusEnum::ENABLED;

    private $createdAt = null;

    private $updatedAt = null;

    private $usages;

    //private $_dotEnvConfig;
    private $_fileHash;

    public function __construct(/*DotEnvConfigInterface $dotEnvConfig,*/ FileHash $fileHash)
    {
        //$this->_dotEnvConfig = $dotEnvConfig;
        $this->createdAt = new DateTime();
        $this->_fileHash = $fileHash;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('hash', new Assert\NotBlank);
        $metadata->addPropertyConstraint('extension', new Assert\NotBlank);
        $metadata->addPropertyConstraint('size', new Assert\NotBlank);
        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
//        $metadata->addPropertyConstraint('description', new Assert\NotBlank);
        $metadata->addPropertyConstraint('statusId', new Assert\Choice([
            'choices' => EnumHelper::getValues(StatusEnum::class)
        ]));
        $metadata->addPropertyConstraint('createdAt', new Assert\NotBlank);
//        $metadata->addPropertyConstraint('updatedAt', new Assert\NotBlank);
    }

    public function unique(): array
    {
        return [
            ['hash', 'extension'],
        ];
    }

    public function setId($value): void
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setHash($value): void
    {
        $this->hash = $value;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function setExtension($value): void
    {
        $this->extension = $value;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function setSize($value): void
    {
        $this->size = $value;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setName($value): void
    {
        $this->name = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($value): void
    {
        $this->description = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setStatusId($value): void
    {
        $this->statusId = $value;
    }

    public function getStatusId()
    {
        return $this->statusId;
    }

    public function setCreatedAt($value): void
    {
        $this->createdAt = $value;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setUpdatedAt($value): void
    {
        $this->updatedAt = $value;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getUri(): string
    {
        $publicUrl = DotEnv::get('STORAGE_PUBLIC_URI');
        return '/' . $publicUrl . '/' . $this->_fileHash->getPath($this->getHash(), $this->getExtension());
//        return '/' . $publicUrl . '/' . UploadHelper::getTargetFileName($this->getHash(), $this->getExtension());
    }

    public function getDirectory(): string
    {
        return dirname($this->getFileName());
    }

    public function getFileName(): string
    {
        return FileHelper::rootPath() . '/' . $this->getRelativeFileName();
    }

    public function getRelativeFileName(): string
    {
        $publicDirectory = DotEnv::get('STORAGE_PUBLIC_DIRECTORY');
        return $publicDirectory . '/' . $this->_fileHash->getPath($this->getHash(), $this->getExtension());
    }

    public function getUsages(): ?Collection
    {
        return $this->usages;
    }

    public function setUsages(Collection $usages): void
    {
        $this->usages = $usages;
    }
}
