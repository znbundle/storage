<?php

namespace ZnBundle\Storage\Yii2\Web\Controllers;

use ZnBundle\Storage\Domain\Entities\FileEntity;
use ZnBundle\Storage\Domain\Filters\FileFilter;
use ZnBundle\Storage\Domain\Interfaces\Services\FileServiceInterface;
use ZnBundle\Storage\Yii2\Web\Forms\FileForm;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\helpers\Url;
use ZnLib\Components\I18Next\Facades\I18Next;
use ZnLib\Web\Components\TwBootstrap\Widgets\Breadcrumb\BreadcrumbWidget;
use ZnYii\Web\Controllers\BaseController;

class FileController extends BaseController
{

    protected $baseUri = '/storage/file';
    protected $formClass = FileForm::class;
    protected $entityClass = FileEntity::class;
    protected $filterModel = FileFilter::class;

    public function __construct(
        string $id,
        Module $module, array $config = [],
        BreadcrumbWidget $breadcrumbWidget,
        FileServiceInterface $service
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->breadcrumbWidget = $breadcrumbWidget;
        $this->breadcrumbWidget->add(I18Next::t('storage', 'file.list'), Url::to([$this->baseUri]));
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['restore'] = $this->getRestoreActionConfig();
        return $actions;
    }

    public function behaviors()
    {
        return [
            //'authenticator' => Behavior::auth(),
            /*'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [StorageFilePermissionEnum::ALL],
                        'actions' => ['index'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [StorageFilePermissionEnum::ONE],
                        'actions' => ['view'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [StorageFilePermissionEnum::CREATE],
                        'actions' => ['create'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [StorageFilePermissionEnum::UPDATE],
                        'actions' => ['update'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [StorageFilePermissionEnum::DELETE],
                        'actions' => ['delete'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [StorageFilePermissionEnum::RESTORE],
                        'actions' => ['restore'],
                    ],
                ],
            ],*/
        ];
    }

    public function with()
    {
        return [
            'usages.service',
            //'usages.author', //todo: баг при использовании нескольких вложенных связей, первая отваливается
        ];
    }
}
