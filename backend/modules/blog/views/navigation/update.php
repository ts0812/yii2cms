<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\blog\navigation */

$this->title = '更新: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Navigations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="navigation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
