<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerJs($this->render('js/create.js'));
/* @var $this yii\web\View */
/* @var $model common\models\Config */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .music-form{
        width: 50%;
        margin-left: 2%;
    }
</style>

<div class="music-form">
<?php $sortArr =  range(1,99);?>
<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'qq')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'object')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'song',['template' => '{label} <div class="row"><div class="col-sm-12">{input}<button type="button" class="layui-btn search_button"><i class="layui-icon"></i>搜索歌曲</button>{error}{hint}</div></div>'])->textInput(['maxlength' => true,'class'=>'layui-input upload_input']) ?>
    <?= $form->field($model, 'lrc')->textarea(['rows'=>3]) ?>
    <?= $form->field($model, 'mp3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ttf')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'background')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'small_image')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'sort')->dropDownList($sortArr) ?>

    <?= $form->field($model, 'playlist')->radioList(\common\models\music\Music::$_playlist) ?>

    <?= $form->field($model, 'state')->radioList(\common\models\music\Music::$_state)?>
    <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'layui-btn' : 'layui-btn layui-btn-normal']) ?>

    <?php ActiveForm::end(); ?>

</div>

