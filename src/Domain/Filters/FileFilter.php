<?php

namespace ZnBundle\Storage\Domain\Filters;

use Packages\Utility\Domain\Filters\BaseStatusFilter;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Filter\DefaultSortInterface;

class FileFilter extends BaseStatusFilter implements DefaultSortInterface
{

    private $title;
    private $viewCount;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        self::loadStatusValidatorMetadata($metadata);
        $metadata->addPropertyConstraint('viewCount', new Assert\PositiveOrZero());
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
