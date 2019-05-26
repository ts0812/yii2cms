<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\music\comment */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .comment-form{
        width: 70%;
        margin: 2% 15%;
    }
</style>
<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'music_id')->dropDownList(\common\models\music\Music::getAllMusicList()) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
