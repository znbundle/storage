<?php

namespace ZnBundle\Storage\Domain;

use ZnCore\Base\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'storage';
    }


}

