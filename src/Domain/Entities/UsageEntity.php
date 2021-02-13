<?php

namespace ZnBundle\Storage\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnBundle\User\Domain\Interfaces\Entities\IdentityEntityInterface;
use ZnCore\Domain\Interfaces\Entity\UniqueInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use DateTime;

class UsageEntity implements ValidateEntityByMetadataInterface, EntityIdInterface, UniqueInterface
{

    private $id = null;

    private $serviceId = null;

    private $entityId = null;

    private $userId = null;

    private $fileId = null;

    private $createdAt = null;

    private $service;

    private $author;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
//        $metadata->addPropertyConstraint('id', new Assert\NotBlank);
        $metadata->addPropertyConstraint('serviceId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('entityId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('userId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('fileId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('createdAt', new Assert\NotBlank);
    }

    public function unique(): array
    {
        return [
            ['serviceId', 'entityId', 'userId', 'fileId'],
        ];
    }

    public function setId($value) : void
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setServiceId($value) : void
    {
        $this->serviceId = $value;
    }

    public function getServiceId()
    {
        return $this->serviceId;
    }

    public function setEntityId($value) : void
    {
        $this->entityId = $value;
    }

    public function getEntityId()
    {
        return $this->entityId;
    }

    public function setUserId($value) : void
    {
        $this->userId = $value;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setFileId($value) : void
    {
        $this->fileId = $value;
    }

    public function getFileId()
    {
        return $this->fileId;
    }

    public function setCreatedAt($value) : void
    {
        $this->createdAt = $value;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getService(): ?ServiceEntity
    {
        return $this->service;
    }

    public function setService(ServiceEntity $service): void
    {
        $this->service = $service;
    }

    public function getAuthor(): ?IdentityEntityInterface
    {
        return $this->author;
    }

    public function setAuthor(IdentityEntityInterface $author): void
    {
        $this->author = $author;
    }
}
