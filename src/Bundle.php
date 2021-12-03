<?php

namespace ZnBundle\Storage;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function symfonyRpc(): array
    {
        return [
            __DIR__ . '/Rpc/config/my-file-routes.php',
        ];
    }

    public function symfonyAdmin(): array
    {
        return [
            __DIR__ . '/Symfony4/Admin/config/routing.php',
        ];
    }

    public function yiiAdmin(): array
    {
        return [
            'modules' => [
                'storage' => __NAMESPACE__ . '\Yii2\Web\Module',
            ],
        ];
    }

    public function i18next(): array
    {
        return [
            'storage' => 'vendor/znbundle/storage/src/Domain/i18next/__lng__/__ns__.json',
        ];
    }

    public function migration(): array
    {
        return [
            '/vendor/znbundle/storage/src/Domain/Migrations',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}
