<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\blog\AppHistory */

$this->title = '添加历程';
$this->params['breadcrumbs'][] = ['label' => 'App Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-history-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    $model->status=1;
    $model->addtime=date('Y-m-d H:i:s');
    ?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
