<?php

namespace ZnBundle\Storage\Symfony4\Api\Controllers;

use ZnLib\Rest\Symfony4\Base\BaseCrudApiController;
use ZnBundle\Storage\Domain\Interfaces\Services\FileServiceInterface;
use ZnLib\Web\Symfony4\WebBundle\Traits\AccessTrait;

class FileController extends BaseCrudApiController
{

    use AccessTrait;

    public $service = null;

    public function __construct(FileServiceInterface $service)
    {
        $this->service = $service;
    }

}
