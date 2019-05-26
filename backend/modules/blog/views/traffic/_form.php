<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\LayuiAsset;
LayuiAsset::register($this);
/* @var $this yii\web\View */
/* @var $model common\models\blog\Article */
/* @var $form yii\widgets\ActiveForm */
?>
<style>

    .traffic-form{
        width: 70%;
        margin: 2% 15%;
    }

</style>
<div class="traffic-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'addtime')->textInput() ?>

    <?= $form->field($model, 'referer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_agent')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
