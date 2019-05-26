<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\LayuiAsset;
LayuiAsset::register($this);
$this->registerJs($this->render('js/index.js'));
/* @var $this yii\web\View */
/* @var $model common\models\Config */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .music-form{
        width: 70%;
        margin: 2% 15%;
    }
</style>
<div class="music-form">
<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'lrc')->textarea(['rows' => '20']) ?>
    <?= Html::button('修改',  ['class' => "layui-btn lrc-edit"]) ?>
    <?php ActiveForm::end(); ?>
</div>
