<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\social\Event */

$this->title = '新增事件';
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$model->status=0;
?>
<div class="event-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
