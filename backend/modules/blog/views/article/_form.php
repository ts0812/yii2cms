<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\LayuiAsset;
LayuiAsset::register($this);
$this->registerJs($this->render('js/upload.js'));
/* @var $this yii\web\View */
/* @var $model common\models\blog\Article */
/* @var $form yii\widgets\ActiveForm */
?>
<style>

    .article-form{
        width: 70%;
        margin: 2% 15%;
    }

</style>
<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords')->textarea(['raw'=>3]) ?>

    <?= $form->field($model, 'description')->textarea(['raw'=>3]) ?>
    <?= $form->field($model, 'image',['template' => '{label} <div class="row"><div class="col-sm-12">{input}<button type="button" class="layui-btn upload_button" id="test3"><i class="layui-icon"></i>上传文件</button>{error}{hint}</div></div>'])->textInput(['maxlength' => true,'class'=>'layui-input upload_input']) ?>
    <?= Html::img(@$model->image, ['width'=>'100','height'=>'100','class'=>'img_pic'])?>
    <?= $form->field($article, 'content')->widget('common\widgets\ueditor\Ueditor',[
        'options'=>[
            'initialFrameWidth' => 1050,//宽度
            'initialFrameHeight' => 550,//高度
        ]
    ]) ?>

    <?= $form->field($model, 'type')->radioList(\common\models\blog\Article::$_type) ?>

    <?= $form->field($model, 'status')->radioList(\common\models\blog\Article::$_status) ?>

    <?php $sortArr = range(0,99);?>
    <?= $form->field($model, 'sort')->dropDownList($sortArr) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
