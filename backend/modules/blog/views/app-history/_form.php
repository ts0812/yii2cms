<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\blog\AppHistory */
/* @var $form yii\widgets\ActiveForm */
?>
<style>

    .app-history-form{
        width: 70%;
        margin: 2% 15%;
    }

</style>
<div class="app-history-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'content')->textarea(['raw'=>3]) ?>

    <?= $form->field($model, 'status')->radioList(\common\models\blog\AppHistory::$_status) ?>

    <?= $form->field($model, 'addtime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
