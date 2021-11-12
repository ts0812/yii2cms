<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\social\EventType;
use common\models\social\Event;
use kartik\datetime\DateTimePicker;
/* @var $this yii\web\View */
/* @var $model common\models\social\Event */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .event-form{
        width: 50%;
        margin-left: 2%;
    }
</style>
<div class="event-form">
    <?php
        $userList = \common\models\social\User::getUserListByName();
        $ownerName = $userList[$model->owner_id]??'';
    ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'type_id')->dropDownList([''=>'选择类型']+EventType::allEventType()) ?>
<!--    需要提交的用户id-->
    <?= $form->field($model, 'owner_id')->hiddenInput(['maxlength' => true]) ?>
<!--    检索用户-->
    <div class="form-group field-event-owner_id required">
        <input list="source" value= "<?= $ownerName ?>" type="text" class="form-control" id="tmpName" >
        <datalist id="source">
            <?php
                foreach ($userList as $k=>$v){
                    echo '<option data-id="'.$k.'" value="'.$v.'"></option>';
                }
            ?>
        </datalist>
        <div class="help-block"></div>
    </div>

    <?= $form->field($model, 'event_time')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii',
            'todayHighlight' => true,
        ]
    ]); ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->radioList(Event::$_status) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <script>
        <?php $this->beginBlock('js_end') ?>
        //检索用户
        $(function() {
            $("#tmpName").on("input", function () {
                var $options = $("#source").children();
                for (var i = 0; i < $options.length; i++) {
                    if ($options.eq(i).val().trim() == $("#tmpName").val().trim()) {
                        $("#event-owner_id").val($options.eq(i).attr("data-id"));
                        break;
                    } else {
                         $("#event-owner_id").val('');
                    }
                }
            })
        })
        <?php $this->endBlock(); ?>
    </script>
    <?php $this->registerJs($this->blocks['js_end'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>

</div>
