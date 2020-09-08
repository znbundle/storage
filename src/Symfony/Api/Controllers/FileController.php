<?php

namespace ZnBundle\Storage\Symfony\Api\Controllers;

use ZnLib\Rest\Base\BaseCrudApiController;
use ZnBundle\Storage\Domain\Interfaces\Services\FileServiceInterface;
use ZnSandbox\Web\Traits\AccessTrait;

class FileController extends BaseCrudApiController
{

    use AccessTrait;

    public $service = null;

    public function __construct(FileServiceInterface $service)
    {
        $this->service = $service;
    }

}
