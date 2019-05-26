<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\music\pv */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pv-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'music_id')->textInput() ?>

    <?= $form->field($model, 'ip_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jiazai_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zaixian_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
