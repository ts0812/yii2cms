<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\social\User */

$this->title = '添加用户';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$model->status=0;
$model->sex=0;
$model->birthday_type=0;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
