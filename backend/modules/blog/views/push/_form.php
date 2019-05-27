<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\blog\Push */
/* @var $form yii\widgets\ActiveForm */
?>
<style>

    .push-form{
        width: 70%;
        margin: 2% 15%;
    }

</style>
<div class="push-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>


    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->radioList(\common\models\blog\Push::$_status) ?>

    <?= $form->field($model, 'label')->radioList(\common\models\blog\Push::$_label) ?>

    <?php $sortArr = range(0,99);?>
    <?= $form->field($model, 'sort')->dropDownList($sortArr) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
