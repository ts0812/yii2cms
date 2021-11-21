<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\assets\LayuiAsset;
use common\models\social\Event;
LayuiAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel common\models\social\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '人情事件';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增事件', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['attribute'=>'type_id','value'=>function($model){
                return $model['eventType']['name']??'';
            },
                'filter'=>\common\models\social\EventType::allEventType()
            ],
            ['attribute'=>'status','value'=>function($model){
                $statusName = Event::$_status[$model->status]??'';
                switch ($model->status){
                    case 0:
                        $txt = '<span style="background-color: green;color: white">'.$statusName.'</span>';
                        break;
                    case 1:
                        $txt = '<span style="background-color: red;color: white">'.$statusName.'</span>';
                        break;
                    default:
                        $txt =   $statusName ;
                        break;
                }
                return $txt;
            },
                'format'=>'raw',
                'filter'=>Event::$_status
            ],
            ['attribute'=>'owner_id','value'=>function($model){
                return $model['user']['name']??'';
            },
            ],
            'description',
//            'create_time',
            //'update_time',
            'event_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
