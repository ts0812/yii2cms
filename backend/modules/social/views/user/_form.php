
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\models\social\User;
use backend\assets\LayuiAsset;
use kartik\datetime\DateTimePicker;
LayuiAsset::register($this);
$this->registerJs($this->render('js/upload.js'));

/* @var $this yii\web\View */
/* @var $model common\models\social\User */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
    .user-form{
        width: 50%;
        margin-left: 2%;
    }
</style>
<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthday')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true,
            'minView'=> "month",
        ]
    ]); ?>
    <?= $form->field($model, 'birthday_type')->radioList(User::userBirthdayType()) ?>
    <?= $form->field($model, 'photo',['template' => '{label} <div class="row"><div class="col-sm-12">{input}<button type="button" class="layui-btn upload_button" id="test3"><i class="layui-icon"></i>上传文件</button>{error}{hint}</div></div>'])->textInput(['maxlength' => true,'class'=>'layui-input upload_input']) ?>
    <?= Html::img(@$model->photo, ['width'=>'100','height'=>'100','class'=>'img_pic'])?>
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sex')->radioList(User::userSex()) ?>
    <?= $form->field($model, 'status')->radioList(User::userStatus()) ?>
    <?= $form->field($model, 'death_time')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii',
            'todayHighlight' => true,
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <script>
        <?php $this->beginBlock('js_end') ?>
        var status = $("input[name='User[status]']:checked").val();
        if(status==0)
            $('.field-user-death_time').css('display','none')
        $("input:radio[name='User[status]']").change(function(){
            status = $("input[name='User[status]']:checked").val();
            let isShow = status==1?'block':'none';
            $('.field-user-death_time').css('display',isShow)
        });
        <?php $this->endBlock(); ?>
    </script>
    <?php $this->registerJs($this->blocks['js_end'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>
</div>