<?php

/**
 * @var View $this
 * @var Request $request
 * @var DataProvider $dataProvider
 * @var ValidationByMetadataInterface $filterModel
 */

use yii\helpers\Url;
use yii\web\Request;
use yii\web\View;
use ZnBundle\Storage\Domain\Entities\FileEntity;
use ZnCore\Base\Byte\Helpers\ByteSizeFormatHelper;
use ZnCore\Base\I18Next\Facades\I18Next;
use ZnCore\Base\Validation\Interfaces\ValidationByMetadataInterface;
use ZnCore\Domain\DataProvider\Libs\DataProvider;
use ZnLib\Web\Widgets\Collection\CollectionWidget;
use ZnLib\Web\Widgets\Format\Formatters\ActionFormatter;
use ZnLib\Web\Widgets\Format\Formatters\LinkFormatter;
use ZnSandbox\Sandbox\Status\Domain\Enums\StatusEnum;
use ZnSandbox\Sandbox\Status\Web\Widgets\FilterWidget;

$this->title = I18Next::t('storage', 'file.list');

$statusWidget = new FilterWidget(StatusEnum::class, $filterModel);

$attributes = [
    [
        'label' => 'ID',
        'attributeName' => 'id',
    ],
    [
        'label' => I18Next::t('storage', 'file.attribute.name'),
        'attributeName' => 'name',
        'sort' => true,
        'formatter' => [
            'class' => LinkFormatter::class,
            'uri' => '/storage/file/view',
        ],
    ],
    [
        'label' => I18Next::t('storage', 'file.attribute.extension'),
        'attributeName' => 'extension',
    ],
    [
        'label' => I18Next::t('storage', 'file.attribute.size'),
        'attributeName' => 'size',
        'value' => function (FileEntity $entity) {
            return ByteSizeFormatHelper::sizeFormat($entity->getSize());
        },
    ],
    [
        'label' => I18Next::t('core', 'main.attribute.created_at'),
        'attributeName' => 'created_at',
        'sort' => true,
    ],
    [
        'formatter' => [
            'class' => ActionFormatter::class,
            'actions' => [
                'update',
                'delete',
            ],
            'baseUrl' => '/storage/file',
        ],
    ],
];

?>

<div class="row">

    <div class="col-lg-12">

        <div class="mb-3">
            <?= $statusWidget->run() ?>
        </div>

        <?= CollectionWidget::widget([
            'dataProvider' => $dataProvider,
            'attributes' => $attributes,
            'filter' => $filterModel,
        ]) ?>

        <div class="float-left">
            <a class="btn btn-primary" href="<?= Url::to(['/storage/file/create']) ?>" role="button">
                <i class="fa fa-plus"></i>
                <?= I18Next::t('core', 'action.create') ?>
            </a>
        </div>

    </div>

</div>
