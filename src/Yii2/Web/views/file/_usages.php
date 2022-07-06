<?php

/**
 * @var View $this
 * @var Request $request
 * @var Enumerable $collection
 * @var ValidationByMetadataInterface $filterModel
 */

use yii\web\Request;
use yii\web\View;
use ZnCore\Validation\Interfaces\ValidationByMetadataInterface;
use ZnCore\Collection\Interfaces\Enumerable;
use ZnLib\I18Next\Facades\I18Next;
use ZnLib\Web\TwBootstrap\Widgets\Collection\CollectionWidget;

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
