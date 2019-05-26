<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\blog\Index */

$this->title = '更新列表: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Indices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="index-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
