<?php

/**
 * @var View $this
 * @var Request $request
 * @var Collection $collection
 * @var ValidationByMetadataInterface $filterModel
 */

use Illuminate\Support\Collection;
use yii\web\Request;
use yii\web\View;
use ZnLib\Components\I18Next\Facades\I18Next;
use ZnCore\Base\Validation\Interfaces\ValidationByMetadataInterface;
use ZnLib\Web\Components\Widget\Widgets\Collection\CollectionWidget;

$attributes = [
    /*[
        'label' => 'ID',
        'attributeName' => 'id',
    ],*/
    [
        'label' => I18Next::t('storage', 'file.attribute.service'),
        'attributeName' => 'service.title',
    ],
    [
        'label' => I18Next::t('storage', 'file.attribute.entityId'),
        'attributeName' => 'entityId',
    ],
    /*[
        'label' => I18Next::t('storage', 'file.attribute.author'),
        'attributeName' => 'author.username',
    ],*/
];

?>

<?= CollectionWidget::widget([
    'collection' => $collection,
    'attributes' => $attributes,
]) ?>
