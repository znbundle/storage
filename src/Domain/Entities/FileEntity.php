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
use ZnCore\Base\Helpers\UrlHelper;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Libs\DotEnv\DotEnv;
//use ZnCore\Base\Libs\DotEnv\DotEnvConfigInterface;
use ZnCore\Base\Libs\FileSystem\Helpers\FilePathHelper;
use ZnCore\Domain\Constraints\Enum;
use ZnCore\Contract\Domain\Interfaces\Entities\EntityIdInterface;
use ZnCore\Domain\Interfaces\Entity\UniqueInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;

class FileEntity implements ValidateEntityByMetadataInterface, EntityIdInterface, UniqueInterface
{

    protected $id = null;

    protected $hash = null;

    protected $extension = null;

    protected $size = null;

    protected $name = null;

    protected $description = null;

    protected $statusId = StatusEnum::ENABLED;

    protected $createdAt = null;

    protected $updatedAt = null;

    protected $usages;
    
    protected $uri;

    protected $url;
    protected $directory;
    protected $fileName;
    protected $relativeFileName;

    //protected $_dotEnvConfig;
    protected $_fileHash;

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
        $metadata->addPropertyConstraint('statusId', new Enum([
            'class' => StatusEnum::class,
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

    public function getUrl()
    {
        $uri = $this->uri;
        $parsedUri = UrlHelper::parse($uri);
        if(isset($parsedUri['scheme'])) {
            return $uri;
        }
        return DotEnv::get('WEB_URL') . $this->getUri();
    }

    public function getUri(): ?string
    {
        if($this->uri) {
            return $this->uri;
        }
        $publicUrl = DotEnv::get('STORAGE_PUBLIC_URI');
        return '/' . $publicUrl . '/' . $this->_fileHash->getPath($this->getHash(), $this->getExtension());
//        return '/' . $publicUrl . '/' . UploadHelper::getTargetFileName($this->getHash(), $this->getExtension());
    }

    public function setUri(?string $uri): void
    {
        $this->uri = $uri;
    }

    public function getDirectory(): string
    {
        return dirname($this->getFileName());
    }

    public function getFileName(): string
    {
        return FilePathHelper::rootPath() . '/' . $this->getRelativeFileName();
    }

    public function getRelativeFileName(): string
    {
        $publicDirectory = DotEnv::get('STORAGE_PUBLIC_DIRECTORY');
        return $publicDirectory . '/' . $this->_fileHash->getPath($this->getHash(), $this->getExtension());
    }

    /**
     * @return Collection|null|UsageEntity[]
     */
    public function getUsages(): ?Collection
    {
        return $this->usages;
    }

    public function setUsages(?Collection $usages): void
    {
        $this->usages = $usages;
    }
}
