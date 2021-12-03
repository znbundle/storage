<?php

namespace ZnBundle\Storage\Rpc\Controllers;

use ZnBundle\Storage\Domain\Interfaces\Services\MyFileServiceInterface;
use ZnBundle\User\Domain\Interfaces\Services\IdentityServiceInterface;
use ZnLib\Rpc\Rpc\Base\BaseCrudRpcController;

class MyFileController extends BaseCrudRpcController
{

    public function __construct(MyFileServiceInterface $myFileService)
    {
        $this->service = $myFileService;
    }

    /*public function allowRelations(): array
    {
        return [
            'person'
        ];
    }*/
}
