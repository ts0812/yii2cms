<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\mini\GoodsCatalog */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .goods-catalog-form{
        width: 70%;
        margin: 0 15%;
        padding-top:5% ;
    }
</style>

<div class="goods-catalog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->radioList(\common\models\mini\GoodsCatalog::$_status) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
