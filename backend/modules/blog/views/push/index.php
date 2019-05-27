<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\assets\LayuiAsset;
LayuiAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel common\models\blog\PushSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '推送';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="push-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加推送', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'content:ntext',
            'url:url',
            ['attribute'=>'label','value'=>function($model){
                return (\common\models\blog\Push::$_label)[$model->label]??'';
            }, 'format'=>'raw',
                'filter'=>\common\models\blog\Push::$_label
            ],
            ['attribute'=>'status','value'=>function($model){
                return (\common\models\blog\Push::$_status)[$model->status]??'';
            }, 'format'=>'raw',
                'filter'=>\common\models\blog\Push::$_status
            ],
            'sort',

            'addtime',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
