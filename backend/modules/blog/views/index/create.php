<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\blog\Index */

$this->title = '添加列表';
$this->params['breadcrumbs'][] = ['label' => 'Indices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="index-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    $model->status=1;
    ?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
