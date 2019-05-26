<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\music\pv */

$this->title = 'Update Pv: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pvs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pv-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
