<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\blog\PushSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="push-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'content') ?>

    <?= $form->field($model, 'sort') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'label') ?>

    <?php // echo $form->field($model, 'addtime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
