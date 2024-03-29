<?php

namespace ZnBundle\Storage\Domain\Filters;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Constraints\Enum;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnCore\Domain\Interfaces\Filter\DefaultSortInterface;
use ZnSandbox\Sandbox\Status\Domain\Enums\StatusEnum;

class FileFilter implements ValidateEntityByMetadataInterface, DefaultSortInterface
{

    private $title;
    private $viewCount;
    protected $statusId = StatusEnum::ENABLED;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('statusId', new Enum([
            'class' => StatusEnum::class,
        ]));
        $metadata->addPropertyConstraint('viewCount', new Assert\PositiveOrZero());
    }

    public function setStatusId(int $value): void
    {
        $this->statusId = $value;
    }

    public function getStatusId()
    {
        return $this->statusId;
    }

    public function defaultSort(): array
    {
        return [
            'created_at' => SORT_DESC,
        ];
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getViewCount()
    {
        return $this->viewCount;
    }

    public function setViewCount($viewCount): void
    {
        $this->viewCount = $viewCount;
    }

}
