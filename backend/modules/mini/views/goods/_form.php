<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\LayuiAsset;
LayuiAsset::register($this);

$this->registerJs($this->render('js/upload.js'));

/* @var $this yii\web\View */
/* @var $model common\models\mini\Goods */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .img_pic{
        border: 1px solid #d6e9c6;
        margin-top: -22px;
    }
    .goods-form{
        width: 70%;
        margin: 2% 15%;
    }

</style>
<div class="goods-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'catalog_id')->dropDownList([''=>'选择分类']+\common\models\mini\GoodsCatalog::getAllGoodsCatalog()) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img',['template' => '{label} <div class="row"><div class="col-sm-12">{input}<button type="button" class="layui-btn upload_button" id="test3"><i class="layui-icon"></i>上传文件</button>{error}{hint}</div></div>'])->hiddenInput(['maxlength' => true,'class'=>'layui-input upload_input']) ?>
    <?= Html::img(@$model->img, ['width'=>'100','height'=>'100','class'=>'img_pic'])?>
    <?= $form->field($model, 'show_img')->widget('common\widgets\batch_upload\FileUpload') ?>

    <?= $form->field($model, 'or_price')->textInput() ?>

    <?= $form->field($model, 'pr_price')->textInput() ?>

    <?= $form->field($model, 'status')->radioList(\common\models\mini\Goods::$_status) ?>

    <?= $form->field($model, 'num')->textInput() ?>
    <?= $form->field($model, 'label_ids')->checkboxList(\common\models\mini\Label::getAllLabel()) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$js = <<<JS
JS;
$this->registerJs($js,\yii\web\View::POS_END);
?>

