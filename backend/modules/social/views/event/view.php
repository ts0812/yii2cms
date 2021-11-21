<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\social\Event */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="event-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            ['attribute'=>'type_id','value'=>function($model){
                return (common\models\social\EventType::allEventType())[$model->type_id]??'';
            },
            ],
            ['attribute'=>'owner_id','value'=>function($model){
                return (\common\models\social\User::getUserListById($model->type_id))['name']??'';
            },
            ],
            'description',
            'create_time',
            'update_time',
            'event_time',
            ['attribute'=>'status','value'=>function($model){
                return (\common\models\social\Event::$_status[$model->status]??'');
            },
            ],
        ],
    ]) ?>

</div>
