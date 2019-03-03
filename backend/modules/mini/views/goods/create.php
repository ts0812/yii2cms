<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\mini\Goods */

$this->title = '添加商品';
$this->params['breadcrumbs'][] = ['label' => 'Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>


</style>
<div class="goods-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    $model->status=1;
    ?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
