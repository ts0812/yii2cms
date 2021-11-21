<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\social\EventType */

$this->title = '新增类型';
$this->params['breadcrumbs'][] = ['label' => 'Event Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
