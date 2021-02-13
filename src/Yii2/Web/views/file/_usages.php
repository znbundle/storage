<?php

/**
 * @var View $this
 * @var Request $request
 * @var Collection $collection
 * @var ValidateEntityByMetadataInterface $filterModel
 */

use Illuminate\Support\Collection;
use yii\web\Request;
use yii\web\View;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnLib\Web\Widgets\Collection\CollectionWidget;

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
