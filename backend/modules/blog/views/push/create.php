<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\blog\Push */

$this->title = '添加推送';
$this->params['breadcrumbs'][] = ['label' => 'Pushes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="push-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    $model->status=1;
    ?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
