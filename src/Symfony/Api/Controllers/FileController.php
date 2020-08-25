<?php

namespace PhpBundle\Storage\Symfony\Api\Controllers;

use PhpLab\Rest\Base\BaseCrudApiController;
use PhpBundle\Storage\Domain\Interfaces\Services\FileServiceInterface;
use PhpLab\Web\Traits\AccessTrait;

class FileController extends BaseCrudApiController
{

    use AccessTrait;

    public $service = null;

    public function __construct(FileServiceInterface $service)
    {
        $this->service = $service;
    }

}
