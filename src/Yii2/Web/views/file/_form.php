<?php

/**
 * @var View $this
 * @var Request $request
 * @var FileForm $model
 */

use ZnBundle\Storage\Yii2\Admin\Forms\FileForm;
use yii\helpers\Html;
use yii\web\Request;
use yii\web\View;
use yii\widgets\ActiveForm;
use ZnLib\Components\I18Next\Facades\I18Next;
use ZnYii\Assets\Summernote\SummernoteAsset;
use ZnYii\Web\Widgets\CancelButton\CancelButtonWidget;

SummernoteAsset::register($this);

?>

<div class="row">

    <div class="col-lg-12">

        <?php $form = ActiveForm::begin(['id' => 'fileform']) ?>

        <div class="form-row">
            <div class="form-group col-md-12">
                <?= Html::activeLabel($model, 'title'); ?>
                <?= Html::activeTextInput($model, 'title', ['class' => 'form-control']); ?>
                <?= Html::error($model, 'title', ['class' => 'text-danger']); ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <?= Html::activeLabel($model, 'content'); ?>
                <?= Html::activeTextarea($model, 'content', ['class' => 'form-control summernote']); ?>
                <?= Html::error($model, 'content', ['class' => 'text-danger']); ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <?= Html::activeLabel($model, 'source_url'); ?>
                <?= Html::activeTextInput($model, 'source_url', ['class' => 'form-control']); ?>
                <?= Html::error($model, 'source_url', ['class' => 'text-danger']); ?>
            </div>
        </div>

        <?= Html::submitButton(I18Next::t('core', 'action.save'), ['class' => 'btn btn-success']) ?>

        <?= CancelButtonWidget::widget() ?>

        <?php ActiveForm::end() ?>

    </div>

</div>
