<?php

namespace ZnBundle\Storage\Symfony4\Admin\Controllers;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use ZnBundle\Notify\Domain\Interfaces\Services\ToastrServiceInterface;
use ZnBundle\Storage\Domain\Interfaces\Services\FileServiceInterface;
use ZnBundle\Storage\Domain\Interfaces\Services\UploadServiceInterface;
use ZnBundle\Storage\Symfony4\Admin\Forms\FileForm;
use ZnCore\Base\Exceptions\ReadOnlyException;
use ZnCore\Base\Legacy\Yii\Helpers\Url;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnLib\Web\Symfony4\MicroApp\BaseWebCrudController;
use ZnLib\Web\Symfony4\MicroApp\Interfaces\ControllerAccessInterface;
use ZnLib\Web\Widgets\BreadcrumbWidget;

class FileController extends BaseWebCrudController implements ControllerAccessInterface
{

    protected $viewsDir = __DIR__ . '/../views/file';
    protected $baseUri = '/storage/file';
    protected $formClass = FileForm::class;
    protected $uploadService;

    public function __construct(
        ToastrServiceInterface $toastrService,
        FormFactoryInterface $formFactory,
        CsrfTokenManagerInterface $tokenManager,
        BreadcrumbWidget $breadcrumbWidget,
        FileServiceInterface $service,
        UploadServiceInterface $uploadService
    )
    {
        $this->setService($service);
        $this->setToastrService($toastrService);
        $this->setFormFactory($formFactory);
        $this->setTokenManager($tokenManager);
        $this->setBreadcrumbWidget($breadcrumbWidget);
        $this->uploadService = $uploadService;

        $title = 'File';
        $this->getBreadcrumbWidget()->add($title, Url::to([$this->getBaseUri()]));
    }

    protected function titleAttribute(): string
    {
        return 'name';
    }

    protected function runCreate(object $form) {
        /** @var FileForm $form */
        $this->uploadService->uploadFile($form->getServiceId(), $form->getEntityId(), $form->getFile());
    }

    public function update(Request $request): Response
    {
        throw new ReadOnlyException();
    }
}
