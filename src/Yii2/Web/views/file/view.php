<?php

/**
 * @var View $this
 * @var Request $request
 * @var FileEntity $entity
 */

use yii\web\Request;
use yii\web\View;
use ZnBundle\Storage\Domain\Entities\FileEntity;
use ZnCore\Base\Byte\Helpers\ByteSizeFormatHelper;
use ZnLib\Web\Helpers\Html;
use ZnCore\Base\I18Next\Facades\I18Next;
use ZnLib\Web\Widgets\Detail\DetailWidget;
use ZnLib\Web\Widgets\Format\Formatters\LinkFormatter;
use ZnYii\Base\Helpers\ActionHelper;

$this->title = $entity->getName() . '.' . $entity->getExtension();

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
        //'attributeName' => 'size',
        'value' => function (FileEntity $entity) {
            return ByteSizeFormatHelper::sizeFormat($entity->getSize());
        },
    ],
    [
        'label' => I18Next::t('storage', 'file.attribute.link'),
        'format' => 'html',
        'value' => function (FileEntity $entity) {
            $path = $entity->getUri();
            return Html::a($path, $path, ['target' => '_blank']);
        },
    ],
    [
        'label' => I18Next::t('core', 'main.attribute.created_at'),
        'attributeName' => 'created_at',
        'sort' => true,
    ],
    /*[
        'formatter' => [
            'class' => ActionFormatter::class,
            'actions' => [
                'update',
                'delete',
            ],
            'baseUrl' => '/storage/file',
        ],
    ],*/
];

?>

    <div class="row">

        <div class="col-lg-12">

            <?= DetailWidget::widget([
                'entity' => $entity,
                'attributes' => $attributes,
            ]) ?>

            <div class="float-left">
                <?= ActionHelper::generateUpdateAction($entity, '/storage/file', ActionHelper::TYPE_BUTTON) ?>
                <?= ActionHelper::generateRestoreOrDeleteAction($entity, '/storage/file', ActionHelper::TYPE_BUTTON) ?>
            </div>

        </div>

    </div>

    <h3>
        Usages
    </h3>

<?= $this->render('_usages', [
    'collection' => $entity->getUsages(),
]) ?>